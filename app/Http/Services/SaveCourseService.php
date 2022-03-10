<?php

namespace App\Http\Services;

use App\Models\Price;
use App\Commands\SendingCommand;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Longman\TelegramBot\Exception\TelegramException;

class SaveCourseService
{
    public static function save()
    {
        $currency = ['USDT_RUB', 'BTC_USD'];
        $apiUrl = env("API_EXMO");
        $response = Http::get($apiUrl);
        $result = $response->json();
        $res = json_decode(json_encode($result));

        // foreach($currency as $type){
        //     $flight = new Price;
        //     $flight->type = $type;
        //     $flight->price = round($res->$type->buy_price, 2);
        //     $flight->save();
        // }

        foreach($currency as $type){
            $model = Price::where('type', '=', $type)->first();
            $model->price = round($res->$type->buy_price, 2);
            $model->save();
        }
    }
}
