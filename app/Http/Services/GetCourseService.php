<?php

namespace App\Http\Services;

use Exception;
use App\Models\Price;
use App\Models\FearIndex;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use App\Http\Services\ParserService;
use Illuminate\Support\Facades\Http;
use Longman\TelegramBot\Exception\TelegramException;

class GetCourseService
{
    public static function getCourse()
    {
        try{
        $courseUSD = Price::where('type', '=', 'USDT_RUB')->first()->price;
        $courseBTC = Price::where('type', '=', 'BTC_USD')->first()->price;
        $indexFear = FearIndex::where('type', '=', 'Fear Index')->first()->value;
        
        $date = new \DateTime();
        $date->setTimestamp(time());
        $d =  $date->format('Y-m-d H:i');

        return "Updated {$d} \n\nUSDT\_RUB: *$courseUSD*₽ \nBTC\_USD: *$courseBTC*$ \nFear & Greed Index: *$indexFear*";

        } catch (Exception $e) {
            return 'Ошибка загрузки данных 501';
        }
    }
}
