<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Exception\TelegramException;

class SetHookController extends Controller
{
    public function setWebhook()
    {
        // echo __DIR__;
        $bot_api_key  = '5219957463:AAGnJIAs6GV57lTNmAX9uilW0xTr8Onb054';
        $bot_username = 'quoteMonitoringBot';
        $hook_url     = "https://tgm.mikhailov06.ru/api/telegram";

        try {
            // Create Telegram API object
            $telegram = new Telegram($bot_api_key, $bot_username);

            // Set webhook
            $result = $telegram->setWebhook($hook_url);
            if ($result->isOk()) {
                echo $result->getDescription();
            }
        } catch (TelegramException $e) {

            // log telegram errors
            echo $e->getMessage();
        }
    }
}