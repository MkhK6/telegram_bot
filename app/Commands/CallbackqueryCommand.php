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

use App\Commands\UsdCommand;
use App\Commands\SendingCommand;
use Longman\TelegramBot\Request;
use Illuminate\Support\Facades\Log;
use App\Commands\SubscriptionsCommand;
use App\Http\Services\TelegramService;
use App\Commands\BackSubscriptionsCommand;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;


/**
 * Callback query command
 */
class CallbackqueryCommand extends SystemCommand
{
    /**
     * @var callable[]
     */
    protected static $callbacks = [];

    /**
     * @var string
     */
    protected $name = 'callbackquery';

    /**
     * @var string
     */
    protected $description = 'Reply to callback query';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * Command execute method
     *
     * @return ServerResponse
     */
    public function execute(): ServerResponse
    {
        $telegram = TelegramService::getTelegram();
        $telegram->handle();
        
        //$user_id        = $callback_query->getFrom()->getId();
        //$query_id       = $callback_query->getId();
        //$query_data     = $callback_query->getData();

        $answer         = null;
        $callback_query = $this->getCallbackQuery();
        $callback_data = $callback_query->getData();
        $user_id = $callback_query->getFrom()->getId();
        $callback_query_id = $callback_query->getId();

        // Call all registered callbacks.
        foreach (self::$callbacks as $callback) {
            $answer = $callback($callback_query);
        }
        
        // Log::debug($callback_query);
        if ($callback_data == 'update') {
            $messageCommand = new UpdateCommand($telegram, null, $callback_query);
            $messageCommand->execute();
        } else if ($callback_data == 'subscriptions') {
            $messageCommand2 = new SubscriptionsCommand($telegram, null, $callback_query);
            $messageCommand2->execute();
            Log::debug($callback_query->getFrom()->getFirst_name() . ' подписался на обновления, id:' . $callback_query->getFrom()->getId());
        }
        else if ($callback_data == 'back-subscriptions') {
            $messageCommand2 = new BackSubscriptionsCommand($telegram, null, $callback_query);
            $messageCommand2->execute();
            Log::debug($callback_query->getFrom()->getFirst_name() . ' отписался от обновлений, id:' . $callback_query->getFrom()->getId());
        }
        return ($answer instanceof ServerResponse) ? $answer : $callback_query->answer();
    }

    /**
     * Add a new callback handler for callback queries.
     *
     * @param $callback
     */
    public static function addCallbackHandler($callback): void
    {
        self::$callbacks[] = $callback;
    }
}
