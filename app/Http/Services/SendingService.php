<?php

namespace App\Http\Services;

use App\Models\Subscription;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Illuminate\Support\Facades\Http;
use Longman\TelegramBot\Exception\TelegramException;

class SendingService
{
    public static function sending()
    {

            $data = [
                "text" => 'Хихихи',
                'chat_id' => 348218254,
            ];
            
            Request::sendMessage($data);


        // foreach (Subscription::all() as $flight) {
        //     $data = [
        //         "text" => 'Хихихи',
        //         'chat_id' => $flight->user_id,
        //     ];
            
        //     Request::sendMessage($data);
        // }
    }
}
