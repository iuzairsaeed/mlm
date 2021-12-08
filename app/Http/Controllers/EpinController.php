<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pin;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\GeneralSetting;
use App\Models\Deposit;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Auth;

class EpinController extends Controller
{
	public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function epin()
    {
        $pageTitle = "Recharge your wallet";
        $emptyMessage = "No data found";
        $user = Auth::user();
        $pins = Pin::where('generate_user_id', $user->id)->latest()->paginate(getPaginate());
        return view($this->activeTemplate.'user.epin_recharge', compact('pageTitle', 'emptyMessage', 'pins'));
    }

    public function eRecharge(Request $request)
    {
        $this->validate($request, [
            'pin' => 'required|exists:pins,pin'
        ]);
        $general = GeneralSetting::first();
        $user = Auth::user();
        $pin = Pin::where('pin', $request->pin)->where('status', 0)->first();
        if(!$pin)
        {
            $notify[] = ['error', 'Already used this pin.'];
            return back()->withNotify($notify);
        }
        $userPin = Pin::where('pin', $request->pin)->where('status', 0)->where('generate_user_id', $user->id)->first();
        if($userPin)
        {
            $notify[] = ['error', 'You can not e-pin recharge to self account.'];
            return back()->withNotify($notify);
        }
        $pin->status = 1;
        $pin->user_id = $user->id;
        $pin->save();
      
        $user->balance += $pin->amount;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $pin->amount;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type = '+';
        $transaction->mark = 1;
        $transaction->details = 'E-Pin recharge via ' . $pin->pin;
        $transaction->trx = getTrx();
        $transaction->save();

        $deposit = new Deposit();
        $deposit->user_id = $user->id;
        $deposit->method_code = 0;
        $deposit->method_currency = $general->cur_text;
        $deposit->amount = $pin->amount;
        $deposit->rate = 1;
        $deposit->final_amo = $pin->amount;
        $deposit->btc_amo = 0;
        $deposit->btc_wallet = "";
        $deposit->trx = $transaction->trx;
        $deposit->try = 0;
        $deposit->status = 1;
        $deposit->save();

        notify($user, 'PIN_RECHARGE', [
            'trx' => $transaction->trx,
            'pin_number' => $pin->pin,
            'amount' => getAmount($pin->amount),
            'currency' => $general->cur_text,
            'post_balance' => getAmount($user->balance),
        ]);

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'Deposit successful via e-pin';
        $adminNotification->click_url = urlPath('admin.deposit.successful');
        $adminNotification->save();

        $notify[] = ['success', 'Balance has been added to your account'];
        return back()->withNotify($notify);
    }

    public function epinRechargeLog()
    {
        $user = Auth::user();
        $pageTitle = 'Recharge History';
        $emptyMessage = 'No data found.';
        $transactions = Transaction::where('user_id', $user->id)->where('mark', 1)->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.transaction', compact('pageTitle', 'emptyMessage', 'transactions'));
    }

    public function pinGenerate(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|gt:0'
        ]);
        $general = GeneralSetting::first();
        $user = Auth::user();
        if($request->amount > $user->balance){
            $notify[] = ['error', 'Your account balance '.getAmount($user->balance) . ' ' . $general->cur_text .' not enough for created pin.'];
            return back()->withNotify($notify);
        }
        $charge = 0;
        if($general->epin_status == 1){
            $charge = (($request->amount / 100) * $general->epin_charge);
        }
        $user->balance -= ($request->amount + $charge);
        $user->save();

        $pin = new Pin();
        $pin->generate_user_id = $user->id;
        $pin->amount = $request->amount;
        $pin->pin = rand(1000,9999).time().rand(1000,9999);
        $pin->details = "Created via " .$user->username;
        $pin->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $pin->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = $charge;
        $transaction->trx_type = '-';
        $transaction->details = 'Created E-pin';
        $transaction->trx = getTrx();
        $transaction->save();

        $withdraw = new Withdrawal();
        $withdraw->method_id = 0;
        $withdraw->user_id = $user->id;
        $withdraw->amount = $pin->amount;
        $withdraw->currency = $general->cur_text;
        $withdraw->rate = 1;
        $withdraw->charge = $charge;
        $withdraw->final_amount = $pin->amount - $charge;
        $withdraw->after_charge = $pin->amount - $charge;
        $withdraw->trx = $transaction->trx;
        $withdraw->status = 1;
        $withdraw->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'Withdraw successful via e-pin';
        $adminNotification->click_url = urlPath('admin.withdraw.approved');
        $adminNotification->save();
        $notify[] = ['success', 'The pin has been created'];
        return back()->withNotify($notify);
    }


    public function assign_pin(Request $request, $id){

        Pin::where('id',$id)->update(array(
            'user_id' => $request->user,
            'status' => 1
        ));
        $notify[] = ['success', 'E-Pin Assign to user.'];
        return back()->withNotify($notify);
    }
}
