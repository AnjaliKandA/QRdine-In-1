<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\User;


class Table extends Authenticatable
{


    protected $table='table_waiter';

    public function waiter(){
        return $this->belongsTo(User::class,'waiter_id','id');
    }
   

}
