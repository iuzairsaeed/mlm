<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Level;
class Plan extends Model
{
    use HasFactory;

    public function level()
    {
    	return $this->hasMany(Level::class, 'plan_id');
    }

    public function sumLevelOfCommission($plan_id)
    {
    	$gnl = GeneralSetting::first();
    	return Level::where('plan_id', $plan_id)->where('level','<=',  $gnl->matrix_height)->sum('amount');
    }

    public function totalLevel($plan_id)
    {
        $gnl = GeneralSetting::first();
        return  Level::where('plan_id', $plan_id)->where('level','<=',  $gnl->matrix_height)->get();
    }

}
