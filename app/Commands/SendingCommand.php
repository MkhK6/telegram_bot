<?php

/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Commands;

use App\Models\Price;
use App\Models\FearIndex;
use App\Models\Subscription;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Illuminate\Support\Facades\Log;
use App\Http\Services\ParserService;
use Illuminate\Support\Facades\Http;
use App\Http\Services\SendingService;
use App\Http\Services\TelegramService;
use App\Http\Services\GetCourseService;
use App\Http\Services\SaveCourseService;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\ServerResponse;

/**
 * Mes command
 */
class SendingCommand extends MainCommand
{
    /**
     * @var string
     */
    protected $name = 'sending';

    /**
     * @var string
     */
    protected $description = 'Sending command';

    /**
     * @var string
     */
    protected $usage = '';

    /**
     * @var string
     */
    protected $version = '1.2.0';

    /**
     * Command execute method
     *
     * @return ServerResponse
     */
    public function executeMorning(): ServerResponse
    {
        Log::debug('Утренняя рассылка началась');
        $courseUSD = Price::where('type', '=', 'USDT_RUB')->first()->price;
        $indexFear = FearIndex::where('type', '=', 'Fear Index')->first()->value;

        foreach (Subscription::all() as $user) {
            $data = [
                "text" => 'Начинаем день с курса USD: ' . $courseUSD . '₽, индекс жадности: ' . $indexFear,
                'chat_id' => $user->user_id,
            ];
            $res = Request::sendMessage($data);
        }
        Log::debug('Утренняя рассылка окончена');

        return $res;
    }

    public function executNight(): ServerResponse
    {
        Log::debug('Вечерняя рассылка окончена');

        $courseUSD = Price::where('type', '=', 'USDT_RUB')->first()->price;
        $indexFear = FearIndex::where('type', '=', 'Fear Index')->first()->value;
        foreach (Subscription::all() as $user) {
            $data = [
                'text' => 'Заканчиваем день с курсом USD: ' . $courseUSD . '₽, индекс жадности: ' . $indexFear,
                'chat_id' => $user->user_id,
            ];

            $res = Request::sendMessage($data);
        }
        Log::debug('Вечерняя рассылка окончена');
        return $res;
    }
}
