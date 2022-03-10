<?php

namespace App\Http\Services;

use App\Models\Price;
use App\Models\Subscription;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;

class SubscriptionService
{
    public static function subscription($id)
    {
        $flight = new Subscription;
        $flight->user_id = $id->getFrom()->getId();
        $flight->name = $id->getFrom()->getFirst_name();
        $flight->save();
    }

    public static function backSubscription($id)
    {
        $flight = Subscription::where('user_id', $id->getFrom()->getId());
        $flight->delete();
    }
}
