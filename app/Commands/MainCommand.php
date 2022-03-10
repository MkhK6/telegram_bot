<?php

namespace App\Commands;

use App\Commands\BaseCommand;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Entities\Update;

/**
 * Mes command
 */
class MainCommand extends BaseCommand{
    
    public function __construct(Telegram $telegram, Update $update = null, $callback_query = null)
    {
        parent::__construct($telegram, $update);
        $this->callback_query = $callback_query;
    }
}