<?php

namespace App\Http\Services;

use App\Models\Price;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Longman\TelegramBot\Exception\TelegramException;

class DeleteCourseService
{
    public static function delete()
    {
        // $timestamp = time() - 5 * 60;
        // $datetimeFormat = 'Y-m-d H:i:s';

        // $date = new \DateTime();
        // $date->setTimestamp($timestamp);
        // $result =  $date->format($datetimeFormat);
        // return Price::where('created_at', '<', $result)->delete();
        // $val = Price::latest('created_at')->first();

        // print_r($val);
        $date = Price::latest('created_at')->first()->updated_at;
        $datetimeFormat = 'Y-m-d H:i';
        return $date->format($datetimeFormat);
        // $val->price = 200;
        // $val->save();
        // return Price::latest('created_at')->first();
    }
}
