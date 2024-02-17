<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class NotificationTemplate extends Model
{
    use HasFactory;


    protected $table = 'notification_templates';

    protected $fillable = [
        'user_id',
        'order_id',
        'content',
        'type',
        'readed',
        'redirect_url',
    ];

    public function order()
    {
        return $this->hasOne(Order::class, 'order_id');
    }
}