<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Rules\FileTypeValidate;
use App\Models\WithdrawMethod;
use Illuminate\Http\Request;
use App\Models\User;

class BonusController extends Controller
{
    public function index(){
        $pageTitle = "Send Bonus";
        $users = User::where('status',1)->where('sv',1)->where('tv',1)->paginate(10);
        return view('admin.bonus.index',get_defined_vars());
    }

    public function bulkbonus(Request $request){
        $balance = 0;
       $previous_balances = User::where('status',1)->where('sv',1)->where('tv',1)->get();
            foreach($previous_balances as $previous_balance){
                $new_balance = $balance + $request->bonus_amount + getAmount($previous_balance->balance);
      
                User::where('id',$previous_balance->id)->update(array(
                    'balance' => $new_balance
                ));
        }
        $notify[] = ['success', 'Bonus send to all users.'];
        return back()->withNotify($notify);
    }

    public function user_facebook(){
        $pageTitle = "List Facebook Links";
        $user_list = User::where('status',1)->paginate(12);
        return view('admin.user_facebook',get_defined_vars());
    }
}
