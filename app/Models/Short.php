<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Short extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }


    public function scopeOlderThanDay($query){
        return $query->where("created_at",'<',Carbon::yesterday());
    }
}
