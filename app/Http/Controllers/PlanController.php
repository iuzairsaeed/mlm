<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Models\Plan;
use App\Models\PlanSubscription;
use App\Models\Commissions;
use App\Models\Transaction;
use App\Models\AdminNotification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\TotalCountReferal;
use App\Models\Refferal;

class PlanController extends Controller
{
	public function __construct(){
        $this->activeTemplate = activeTemplate();
        $this->middleware('auth');
    }  

    public function testing(){
     $test = User::where('id',Auth::user()->id)->get();
        foreach($test as $tests){
            dd($tests);
        }
    }
    public function plan()
    {
        $pageTitle = "Plan Subscribe";
         $emptyMessage = "No plan found";
         $plans = Plan::where('status', 1)->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'plan', compact('pageTitle', 'emptyMessage', 'plans'));
    }

    public function planOrder(Request $request)
    {

      
        // dd(Auth::user()->ref_by);
        $this->validate($request, [
            'planid' => 'required|exists:plans,id'
        ]);
        $user = Auth::user();
        $plan = Plan::where('id',$request->planid)->where('status', 1)->firstOrFail();
        $orderUser = PlanSubscription::where('user_id', $user->id)->first();
        
        // if($orderUser)
        // {
        //     $notify[] = ['error', 'You are already subscribed'];
        //     return back()->withNotify($notify);
        // }

        if($plan->price > $user->balance){
            $notify[] = ['error', 'Your account balance '.getAmount($user->balance) . ' ' . $this->general()->cur_text .' not enough please deposit money in your account.'];
            return back()->withNotify($notify);
        }



        $user->balance -= $plan->price;
        $user->save();

        $trx =  getTrx();
        $order = new PlanSubscription();
        $order->user_id = $user->id;
        $order->plan_id = $plan->id;
        $order->amount = $plan->price;
        $order->order_number = $trx;
        $order->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $order->amount;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type = '-';
        $transaction->details = 'Subscribe Plan '. $plan->name;
        $transaction->trx = $trx;
        $transaction->save();

        notify($user, 'PLAN_SUBSCRIBE', [
            'plan_name' => $plan->name,
            'trx' => $trx,
            'amount' => getAmount($plan->price),
            'currency' => $this->general()->cur_text,
            'post_balance' => getAmount($user->balance),
        ]);

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'Plan subscribe successful';
        $adminNotification->click_url = urlPath('admin.plan.subscribers.index');
        $adminNotification->save();

        $planOrder = PlanSubscription::where('user_id', $user->ref_by)->first();
        if($user->ref_by != null)
        {
            if($planOrder)
            {
    		    $this->positionFixed($user->id);
    		    $this->referralCommission($user->id, $plan->id);
            }
    	}
        if($planOrder){
            $this->levelCommission($user->id, $plan->id);
        }


        $previouse = 0;
        $old_refrence = User::all();
        // dd($old_refrence);
       foreach($old_refrence as $old_refrences){

            $ref = User::where('id',$old_refrences->ref_by)->first();
            // dd($ref);
            if($ref != null){

            $previouse = $ref->total_ppl_buy_packages + 1;
            User::where('id',$ref->id)->update(array(
                'total_ppl_buy_packages' => $previouse,
            ));

            if($ref->total_ppl_buy_packages == 10){
                User::where('id',$ref->id)->update(array(
                    'is_ready_for_bonus' => 1,
                ));
            }
    
            $comission = getAmount($plan->price) + 0.05 * 100;
            $new_balance = $ref->balance + $comission;
            
            if($ref->is_ready_for_bonus == 1){
                User::where('id',$ref->id)->update(array(
                 'balance' =>  $new_balance
                ));
                User::where('id',$ref->id)->update(array(
                    'is_ready_for_bonus' => 0,
                    'total_ppl_buy_packages' => 0,
                    'total_refferals_count' => 0
                ));

                if($ref->membership_count != null){
                    User::where('id',$ref->id)->update(array(
                        'membership_count' => 1,
                        'member_ship' => "Silver MemberShip", 
                    ));
    
                }

                if($ref->membership_count == 1){
                    User::where('id',$ref->id)->update(array(
                        'membership_count' => 2,
                        'member_ship' => "Gold MemberShip", 
                    ));
    
                }
            }
        
        }
        }
        // dd('su');
        $notify[] = ['success', 'The plan has been subscribed'];
        return back()->withNotify($notify);
    }
    
    private function positionFixed($userId)
    {
    	$user = User::find($userId);
    	$referBy = User::find($user->ref_by);
        $checkPosition = 0;
    	if($this->checkReferUserEmpty($referBy->id) != 0){
    		$user->position_id = $referBy->id;
            $user->position =$this->checkReferUserEmpty($referBy->id);
            $user->save();
    	}
    	else{
            for($level=1; $level <100; $level++){
                $myReferralUser = $this->showPosition($referBy->id);
                $nextReferral = $myReferralUser;
                for($i=1; $i<$level; $i++)
                {
                    $nextReferral = array();
                    foreach($myReferralUser as $dataReferral){
                        $n=$this->showPosition($dataReferral);
                        $nextReferral = array_merge($nextReferral, $n);
                    }
                    $myReferralUser = $nextReferral;
                }
                foreach($nextReferral as $valueNextReferral){
                    if($this->checkReferUserEmpty($valueNextReferral) != 0){
                        $user->position_id = $valueNextReferral;
                        $user->position = $this->checkReferUserEmpty($valueNextReferral);
                        $user->save();
                        $checkPosition =1;
                    }
                    if($checkPosition == 1){
                        break;
                    }
                }
                if($checkPosition == 1){
                    break;
                }
            }
    	}
    }

    private function checkReferUserEmpty($referByID)
    {
    	$count = User::where('position_id',$referByID)->count();
        if($count < $this->general()->matrix_width){
            return $count+1;
        }else{
            return 0;
        }
    }

    private function showPosition($referByID)
    {
        $newArray = array();
        $underReferralUser = User::where('position_id', $referByID)->get();
        foreach($underReferralUser as $userValue)
        {
            array_push($newArray, $userValue->id);
        }
        return $newArray;
    }

    private function referralCommission($userId, $planId)
    {
    	$user = User::find($userId);
    	$plan = Plan::find($planId);
    	if($user)
    	{
    		if($user->ref_by != null)
    		{
    			$referral = User::find($user->ref_by);
    			$referral->balance += $plan->referral_bonus;
    			$referral->save();

    			$transaction = new Transaction();
		        $transaction->user_id = $referral->id;
		        $transaction->amount = $plan->referral_bonus;
		        $transaction->post_balance = $referral->balance;
		        $transaction->trx_type = '+';
		        $transaction->details = 'Referral commission from '. $user->username;
		        $transaction->trx = getTrx();
		        $transaction->save();

		        $commission = new Commissions();
                $commission->user_id = $referral->id;
                $commission->from_user_id = $user->id;
                $commission->amount = $plan->referral_bonus;
                $commission->post_balance = $referral->balance;
                $commission->trx = $transaction->trx;
                $commission->mark = 1;
                $commission->details = 'Referral commission from ' . $user->username;
                $commission->save();

                notify($referral, 'REFERRAL_COMMISSION', [
		            'trx' => $commission->trx,
		            'amount' => getAmount($plan->referral_bonus),
		            'currency' => $this->general()->cur_text,
		            'post_balance' => getAmount($referral->balance),
		        ]);

                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $user->id;
                $adminNotification->title = 'Referral commission successful';
                $adminNotification->click_url = urlPath('admin.report.commissions');
                $adminNotification->save();
    		}
    	}
    }

    private function levelCommission($userId, $planId)
    {
        $user = User::find($userId);
        $plan = Plan::find($planId);
        $userInfo = $userId;
        $value = 1;

        while($userInfo != "0" || $userInfo != "0" || $value <= $this->general()->matrix_height)
        {
            $myInfo = User::find($userInfo);
            if($this->userValid($myInfo->position_id) == false)
            {
                break;
            }
            $referral = $this->userValid($myInfo->position_id);
            if($value <= $this->general()->matrix_height)
            {
                $commission = $plan->level->where('level', $value)->first();
                if(!$commission){
                    break;
                }
                $referral->balance += $commission->amount;
                $referral->save();

                $transaction = new Transaction();
                $transaction->user_id = $referral->id;
                $transaction->amount = $commission->amount;
                $transaction->post_balance = $referral->balance;
                $transaction->trx_type = '+';
                $transaction->details = 'Level '. $value. ' commission from ' .$user->username;
                $transaction->trx = getTrx();
                $transaction->save();

                $comm = new Commissions();
                $comm->user_id = $referral->id;
                $comm->from_user_id = $user->id;
                $comm->level = $value;
                $comm->amount = $commission->amount;
                $comm->post_balance = $referral->balance;
                $comm->trx = $transaction->trx;
                $comm->mark = 2;
                $comm->details = 'Level '.$value.' commission from ' . $user->username;
                $comm->save();

                notify($referral, 'LEVEL_COMMISSION', [
                    'trx' => $comm->trx,
                    'amount' => getAmount($commission->amount),
                    'currency' => $this->general()->cur_text,
                    'post_balance' => getAmount($referral->balance),
                ]);
            }
            $userInfo = $referral->id;
            $value++;
        }
    }

    private function userValid($userId){
        $user = User::find($userId);
        return $user ? $user:false;
    }

    private function general()
    {
        return GeneralSetting::first();
    }
}
