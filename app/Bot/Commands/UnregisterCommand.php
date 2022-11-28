<?php

namespace App\Bot\Commands;

use App\Models\Chat;
use App\Models\ChatMember;
use Telegram\Bot\Commands\Command;
use Illuminate\Support\Facades\DB;

class UnregisterCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "unregister";

    /**
     * @var string Command Description
     */
    protected $description = "Unregister Command to remove you from RandomCoffee";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $telegramUpdate = $this->getUpdate();
        $telegramChat = $telegramUpdate->getChat();
        $telegramUser = $telegramUpdate->getMessage()->from;

        try {
            Chat::unregisterChat($telegramChat->id);

            ChatMember::unregisterMember($telegramUser->id);

            // This will send a message using `sendMessage` method behind the scenes to
            // the user/chat id who triggered this command.
            // `replyWith<Message|Photo|Audio|Video|Voice|Document|Sticker|Location|ChatAction>()` all the available methods are dynamically
            // handled when you replace `send<Method>` with `replyWith` and use the same parameters - except chat_id does NOT need to be included in the array.
            $this->replyWithMessage(['text' => 'Done']);

        } catch (\Exception $exception) {
            $this->replyWithMessage(['text' => "Something went wrong {$exception->getMessage()}"]);
        }
    }
}