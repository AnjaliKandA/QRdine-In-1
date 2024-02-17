<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\MiscHelper;
use App\Models\Order;
use App\Models\NotificationTemplate;

class NotificationTemplateController extends Controller
{

    public function sendCashNotification()
    {
        $order = Order::latest()->with('notificationTemplate', 'notificationTemp')->first();
        $orderId = $order->id;
        $userId = $order->user_id;
        // dd($orderId);

        $user_id = $userId;
        $order_id = $orderId;
        $content = "Cash payment notification content";
        $type = "cash_payment";
        $redirect_url = " ";

        MiscHelper::send_notification($user_id, $order_id, $content, $type, $redirect_url);

        return redirect()->route('home');
    }
}
