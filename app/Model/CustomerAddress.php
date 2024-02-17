<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $guarded = [];

    protected $casts = [
        'user_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    public function orders()
    {
        return $this->hasMany(Order::class, 'id', 'order_no');
    }
}
