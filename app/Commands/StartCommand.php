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

use App\Models\Subscription;
use Longman\TelegramBot\Request;
use Illuminate\Support\Facades\Log;
use App\Models\editButtonSubscription;
use App\Http\Services\GetCourseService;
use App\Http\Services\SaveCourseService;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\ServerResponse;

/**
 * Start command
 */
class StartCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'start';

    /**
     * @var string
     */
    protected $description = 'Start command';

    /**
     * @var string
     */
    protected $usage = '/start';

    /**
     * @var string
     */
    protected $version = '1.2.0';

    /**
     * Command execute method
     *
     * @return ServerResponse
     */
    public function execute(): ServerResponse
    {
        $message = $this->getMessage();
        $user_id = $message->getFrom()->getId();

        if (!Subscription::where('user_id', $user_id)->first()) {
            $callback_data = "subscriptions";
            $callback_text = "Подписаться на обновление";
        } else {
            $callback_data = "back-subscriptions";
            $callback_text = "Отписаться от обновлений";
        }

        $text =  GetCourseService::getCourse();
        $inline_keyboard = new InlineKeyboard(
            [
                ['text' => 'Обновить', 'callback_data' => 'update']
            ],
            [
                ['text' => $callback_text, 'callback_data' => $callback_data]
            ],
        );

        $data = [
            'text' => $text,
            'chat_id' => $user_id,
            'reply_markup' => $inline_keyboard,
            'parse_mode' => 'markdown'
        ];

        return Request::sendMessage($data);
    }
}
