<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Waiter;
use App\Model\Table;
use App\Models\NotificationTemplate;
use App\Model\CustomerAddress;

use App\Models\Product;

class Order extends Authenticatable
{
    

    protected $table='orders';

    public function waiter(){
        return $this->belongsTo(Waiter::class,'waiter_id','id');
    }
    public function tabledata(){
        return $this->belongsTo(Table::class,'table_id','id');
    }

 public function notificationTemplate()
    {
        return $this->belongsTo(NotificationTemplate::class, 'order_id', 'id');
    }

    public function notificationTemp()
    {
        return $this->belongsTo(NotificationTemplate::class, 'user_id');
    }
public function customerAddress()
    {
        return $this->hasOne(CustomerAddress::class, 'order_no', 'id');
    }


}
