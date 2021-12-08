<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Refferal extends Model
{
    use HasFactory;
    // protected $with = ['referral'];

 

    // public function referral() {
    //     return $this->hasMany(Refferal::class, 'parent_id');
    // }

}
