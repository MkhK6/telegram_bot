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

use App\Models\Message;
use App\Models\editMessage;
use App\Models\Subscription;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Illuminate\Support\Facades\Log;
use App\Models\editButtonSubscription;
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
class UpdateCommand extends MainCommand
{
    /**
     * @var string
     */
    protected $name = 'update';

    /**
     * @var string
     */
    protected $description = 'Update command';

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
    public function execute(): ServerResponse
    {
        $user_id = $this->callback_query->getFrom()->getId();
        $message_id = $this->callback_query->getMessage()->getMessageId();

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
            'message_id' => $message_id,
            'parse_mode' => 'markdown'
        ];
        return Request::editMessageText($data);
    }
}
