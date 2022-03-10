<?php

namespace App\Http\Services;

use simple_html_dom;
use App\Models\Price;
use App\Models\FearIndex;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Longman\TelegramBot\Exception\TelegramException;

class ParserService
{
    public static function parser()
    {
        include('simple_html_dom.php');
        $url = 'https://bitstat.top/fear_greed.php';

        $html = file_get_html('https://bitstat.top/fear_greed.php');

        $results = [];

        foreach ($html->find('div') as $element) { //выборка всех тегов img на странице
            $results[] = $element->text() . '<br>'; // построчный вывод содержания всех найденных атрибутов src
        }

        $res = '';
        $re = '/Индекс страха: ../m';
        preg_match_all($re, $results[5], $matches, PREG_SET_ORDER, 0);
        foreach ($matches as $arr) {
            $res = $arr[0];
        }
        $result = '';
        $re2 = '/\d+/';
        preg_match($re2, $res, $matches2, PREG_OFFSET_CAPTURE, 0);
        foreach ($matches2 as $arr2) {
            $result = $arr2[0];
        }

        $index = '';

        if ($result <= 25) {
            $index =  "чрезвычайный страх ({$result})";
        } else if ($result >= 26 && $result <= 46) {
            $index =  "страх ({$result})";
        } else if ($result >= 47 && $result <= 54) {
            $index =  "нейтрально ({$result})";
        } else if ($result >= 55 && $result <= 75) {
            $index =  "жадность ({$result})";
        } else if ($result >= 76) {
            $index =  "чрезвычайная жадность ({$result})";
        }

        // $flight = new FearIndex;
        // $flight->type = "Fear Index";
        // $flight->value = $index;
        // $flight->save();
        
        $model = FearIndex::where('type', '=', "Fear Index")->first();
        $model->value = $index;
        $model->save();

        Log::debug('Крон индекс страха: ' . $index);
    }
}
