<?php

namespace App\Helpers;

use App\Models\NotificationTemplate;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class MiscHelper
{
    // public static function send_notification($user_id = NULL, $order_id = NULL, $content = NULL, $type = NULL, $redirect_url = NULL)
    // {
    //     $notification = new NotificationTemplate;

    //     $notification->user_id = $user_id;
    //     $notification->order_id = $order_id;
    //     $notification->content = $content;
    //     $notification->type = $type;
    //     $notification->redirect_url = $redirect_url;

    //     $notification->save();
    //     return true;
    // }
    public static function send_notification($user_id = null, $order_id = null, $content = null, $type = null, $redirect_url = null)
    {
        $validator = Validator::make(
            compact('user_id', 'order_id', 'content', 'type', 'redirect_url'),
            [
                'order_id' => 'unique:notification_templates,order_id',
            ]
        );
        if ($validator->fails()) {
            throw ValidationException::withMessages(['order_id' => ['The order_id has already been taken.']]);
        }

        $notification = new NotificationTemplate;
        $notification->user_id = $user_id;
        $notification->order_id = $order_id;
        $notification->content = $content;
        $notification->type = $type;
        $notification->redirect_url = $redirect_url;

        $notification->save();

        return true;
    }
}
