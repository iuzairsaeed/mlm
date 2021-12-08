<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Level;
use App\Models\Plan;
use App\Models\PlanSubscription;
use Illuminate\Http\Request;
 
class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create()
    {
        $pageTitle = "Plan Create";
        return view('admin.plan.create', compact('pageTitle'));
    }

    public function index()
    {
    	$pageTitle = "All Plan List";
    	$emptyMessage = "No data found";
    	$plans = Plan::latest()->with('level')->paginate(getPaginate());
    	return view('admin.plan.index', compact('pageTitle', 'emptyMessage', 'plans'));
    }

    public function store(Request $request)
    {
    	$gnl = GeneralSetting::first();
        $request->validate([
            'name' => 'required|max:191|unique:plans,name', 
            'price' => 'required|numeric|gt:0',
            'referral_bonus' => 'required|numeric|gt:0',
            'level' => 'required|array',
            'level.*' => 'numeric|gt:0'
        ]);
        
        $plan = new Plan();
        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->referral_bonus = $request->referral_bonus;
        $plan->status = $request->status ? 1 : 0;
        $plan->save();

        $level = Level::where('plan_id', $plan->id)->delete();
        foreach($request->level as $l=>$a)
        {
            $level = new Level();
            $level->plan_id = $plan->id;
            $level->level = $l;
            $level->amount = $a;
            $level->save();
        }
    	$notify[] = ['success', 'The plan has been created'];
        return back()->withNotify($notify);
    }

    public function edit($id)
    {
    	$plan = Plan::findOrFail($id);
    	$pageTitle = $plan->name ." Plan Update";
    	return view('admin.plan.edit', compact('pageTitle', 'plan'));
    }

    public function update(Request $request, $id)
    {
        $gnl = GeneralSetting::first();
    	$request->validate([
    	 	'name' => 'required|max:191|unique:plans,name,'.$id, 
    	 	'price' => 'required|numeric|gt:0',
    	 	'referral_bonus' => 'required|numeric|gt:0',
            'level' => 'required|array',
            'level.*' => 'numeric|gt:0'
    	]);
    	$plan = Plan::findOrFail($id);
    	$plan->name = $request->name;
    	$plan->price = $request->price;
    	$plan->referral_bonus = $request->referral_bonus;
    	$plan->status = $request->status ? 1 : 0;
    	$plan->save();

    	$level = Level::where('plan_id', $plan->id)->delete();
        foreach($request->level as $l=>$a)
        {
            $level = new Level();
            $level->plan_id = $plan->id;
            $level->level = $l;
            $level->amount = $a;
            $level->save();
        }
    	$notify[] = ['success', 'The plan has been updated'];
    	return back()->withNotify($notify);
    }

    public function matrixSetting(Request $request)
    {
        $request->validate([
            'matrix_height' => 'required|integer|gt:0',
            'matrix_width' => 'required|integer|gt:0'
        ]);
    	$gnl = GeneralSetting::first();
    	$gnl->matrix_height = $request->matrix_height;
    	$gnl->matrix_width = $request->matrix_width;
    	$gnl->save();
    	$notify[] = ['success', 'Matrix setting has been updated'];
    	return back()->withNotify($notify);
    }

    public function subscribtionPlan($planId)
    {
        $plan = Plan::findOrFail($planId);
        $pageTitle = $plan->name . " Plan subscription list";
        $emptyMessage = "No data found";
        $subscriptions = PlanSubscription::where('plan_id', $planId)->latest()->paginate(getPaginate());
        return view('admin.plan.subscribers', compact('pageTitle', 'emptyMessage', 'subscriptions'));
    }

    public function subscribersIndex()
    {
        $pageTitle ="All plan subscription list";
        $emptyMessage = "No data found";
        $subscriptions = PlanSubscription::with('user', 'plan')->latest()->paginate(getPaginate());
        return view('admin.plan.subscribers', compact('pageTitle', 'emptyMessage', 'subscriptions'));
    }

    public function subscribersSearchs(Request $request)
    {
        $search = $request->search;
        $pageTitle = "Plan subscription search - " . $search;
        $emptyMessage = "No data found";
        $subscriptions = PlanSubscription::where('order_number', $search)->OrwhereHas('user', function($q) use ($search){
            $q->where('username', 'like', "%$search%");
        })->paginate(getPaginate());
        return view('admin.plan.subscribers', compact('pageTitle', 'emptyMessage', 'subscriptions', 'search'));
    }
}
