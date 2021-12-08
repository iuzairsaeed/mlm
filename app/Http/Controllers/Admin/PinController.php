<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pin;

class PinController extends Controller
{
    public function index()
    {
    	$pageTitle = "All created pin";
    	$emptyMessage = "No data found";
    	$pins = Pin::latest()->with('createUser', 'user')->paginate(getPaginate());
    	return view('admin.pin.index', compact('pageTitle', 'emptyMessage', 'pins'));
    }

    public function store(Request $request)
    {
    	$request->validate([
    	 	'amount' => 'required|numeric|gt:0',
    	 	'number' => 'required|integer|gt:0'
    	]);
    	for ($i=1; $i <= $request->number; $i++) { 
    		$pin = new Pin();
    		$pin->amount = $request->amount;
    		$pin->pin = rand(1000,9999).time().rand(1000,9999);
    		$pin->details = "Created via admin";
    		$pin->save();
    	}
    	$notify[] = ['success', 'The pin has been created'];
    	return back()->withNotify($notify);
    }

    public function used()
    {
    	$pageTitle = "All used pin";
    	$emptyMessage = "No data found";
    	$pins = Pin::where('status', 1)->latest()->with('createUser', 'user')->paginate(getPaginate());
    	return view('admin.pin.index', compact('pageTitle', 'emptyMessage', 'pins'));
    }
    
    public function unUsed()
    {
    	$pageTitle = "All unused pin";
    	$emptyMessage = "No data found";
    	$pins = Pin::where('status', 0)->latest()->paginate(getPaginate());
    	return view('admin.pin.index', compact('pageTitle', 'emptyMessage', 'pins'));
    }

    public function adminPin()
    {
        $pageTitle = "Created the pin via admin";
        $emptyMessage = "No pin found";
        $pins = Pin::whereNull('generate_user_id')->with('createUser', 'user')->latest()->paginate(getPaginate());
        return view('admin.pin.index', compact('pageTitle', 'emptyMessage', 'pins'));
    }

    public function userPin()
    {
        $pageTitle = "Created the pin via users";
        $emptyMessage = "No pin found";
        $pins = Pin::whereNotNull('generate_user_id')->with('createUser', 'user')->paginate(getPaginate());
        return view('admin.pin.index', compact('pageTitle', 'emptyMessage', 'pins'));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $pageTitle = "Pin search - " . $search;
        $emptyMessage = "No data found";
        $pins = Pin::where('pin', $search)->with('createUser', 'user')->paginate(getPaginate());
        return view('admin.pin.index', compact('pageTitle', 'emptyMessage', 'pins', 'search'));
    }

    
}
