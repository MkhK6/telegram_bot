<?php

namespace App\Http\Services;

use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Exception\TelegramException;

abstract class TelegramService
{
    public static function getTelegram()
    {
        $bot_api_key  = env("TGM_KEY");
        $bot_username = env("TGM_USERNAME");

        $mysql_credentials = [
            'host'     => env("DB_HOST"),
            'port'     => env("DB_PORT"),
            'user'     => env("DB_USERNAME"),
            'password' => env("DB_PASSWORD"),
            'database' => env("DB_DATABASE"),
        ];
        // Create Telegram API object
        $telegram = new Telegram($bot_api_key, $bot_username);
        $telegram->enableMySql($mysql_credentials);
        
        $telegram->addCommandsPaths([app_path("Commands") ]); //. "app\Commands"
        // $telegram->setDownloadPath(storage_path('app/public/telegram/photos'));
        return $telegram;

        /**
         * Без БД
         */
        // try {
        //     // Create Telegram API object
        //     $telegram = new Telegram($bot_api_key, $bot_username);
        //     return $telegram;
        //     // $telegram->handle();
        // } catch (TelegramException $e) {
        //     // Silence is golden!
        //     // log telegram errors
        //     // echo $e->getMessage();
        // }
    }
}
