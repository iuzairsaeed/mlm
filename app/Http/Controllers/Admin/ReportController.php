<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commissions;
use App\Models\EmailLog;
use App\Models\Transaction;
use App\Models\UserLogin;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function transaction()
    {
        $pageTitle = 'Transaction Logs';
        $transactions = Transaction::with('user')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No transactions.';
        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'emptyMessage'));
    }

    public function transactionSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $pageTitle = 'Transactions Search - ' . $search;
        $emptyMessage = 'No transactions.';

        $transactions = Transaction::with('user')->whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like',"%$search%");
        })->orWhere('trx', $search)->orderBy('id','desc')->paginate(getPaginate());

        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'emptyMessage','search'));
    }


    public function commissions()
    {
        $pageTitle = 'Commissions Logs';
        $emptyMessage = 'No data found';
        $commissions = Commissions::with('user', 'fromUser')->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.reports.commissions', compact('pageTitle', 'commissions', 'emptyMessage'));
    }

    public function commissionsSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $pageTitle = 'Commissions Search - ' . $search;
        $emptyMessage = 'No data found.';
        $commissions = Commissions::with('user', 'fromUser')->whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like',"%$search%");
        })->orWhere('trx', $search)->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.reports.commissions', compact('pageTitle', 'commissions', 'emptyMessage','search'));
    }

    public function commissionSelect(Request $request)
    {
        $request->validate(['commissions' => 'required|in:1,2']);
        $commi = $request->commissions;
        if($request->commissions == 1)
        {
            $pageTitle = "Referrals Commissions Log";
            $emptyMessage = "No referrals commissions found";
            $commissions = Commissions::with('user')->where('mark',1)->orderBy('id','desc')->paginate(getPaginate());
        }
        elseif($request->commissions == 2)
        {
            $pageTitle = "Level Commissions Log";
            $emptyMessage = "No level commissions found";
            $commissions = Commissions::with('user')->where('mark',2)->orderBy('id','desc')->paginate(getPaginate());
        }
        return view('admin.reports.commissions', compact('pageTitle', 'commissions', 'emptyMessage', 'commi'));    
    }

    public function recharge()
    {
        $pageTitle = 'Recharge Logs';
        $transactions = Transaction::where('mark', 1)->with('user')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No Recharge.';
        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'emptyMessage'));
    }

    public function rechargeSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $pageTitle = 'Recharge Search - ' . $search;
        $emptyMessage = 'No Recharge.';

        $transactions = Transaction::where('mark', 1)->with('user')->whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like',"%$search%");
        })->orWhere('trx', $search)->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.reports.transactions', compact('pageTitle', 'transactions', 'emptyMessage','search'));
    }

    public function loginHistory(Request $request)
    {
        if ($request->search) {
            $search = $request->search;
            $pageTitle = 'User Login History Search - ' . $search;
            $emptyMessage = 'No search result found.';
            $login_logs = UserLogin::whereHas('user', function ($query) use ($search) {
                $query->where('username', $search);
            })->orderBy('id','desc')->with('user')->paginate(getPaginate());
            return view('admin.reports.logins', compact('pageTitle', 'emptyMessage', 'search', 'login_logs'));
        }
        $pageTitle = 'User Login History';
        $emptyMessage = 'No users login found.';
        $login_logs = UserLogin::orderBy('id','desc')->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'emptyMessage', 'login_logs'));
    }

    public function loginIpHistory($ip)
    {
        $pageTitle = 'Login By - ' . $ip;
        $login_logs = UserLogin::where('user_ip',$ip)->orderBy('id','desc')->with('user')->paginate(getPaginate());
        $emptyMessage = 'No users login found.';
        return view('admin.reports.logins', compact('pageTitle', 'emptyMessage', 'login_logs','ip'));

    }

    public function emailHistory(){
        $pageTitle = 'Email history';
        $logs = EmailLog::with('user')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No data found';
        return view('admin.reports.email_history', compact('pageTitle', 'emptyMessage','logs'));
    }
}
