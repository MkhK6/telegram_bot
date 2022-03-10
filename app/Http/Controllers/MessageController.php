<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Longman\TelegramBot\Request;
use Illuminate\Http\Request as RequestL;
use Longman\TelegramBot\Telegram;

use Illuminate\Support\Facades\Log;
use App\Http\Services\TelegramService;
use Longman\TelegramBot\Exception\TelegramException;

class MessageController extends Controller
{
    public function message(RequestL $request)
    {
        Log::debug('hook handling'); //Telegram $telegram,
        $telegram = TelegramService::getTelegram();
        $telegram->handle();
    }
}
