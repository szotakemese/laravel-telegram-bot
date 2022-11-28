<?php

namespace App\Bot\Commands;

use App\Models\Chat;
use App\Models\ChatMember;
use Telegram\Bot\Commands\Command;
use Illuminate\Support\Facades\DB;

class RegisterCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "register";

    /**
     * @var string Command Description
     */
    protected $description = "Register Command to add you to Random Coffee";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $telegramUpdate = $this->getUpdate();
        $telegramChat = $telegramUpdate->getChat();
        $telegramUser = $telegramUpdate->getMessage()->from;

        try {
            $chat = Chat::query()
                ->where('chat_id', '=', $telegramChat->id)
                ->get()
                ->first();

            if(!$chat)
                Chat::registerChat($telegramChat->id);

                ChatMember::registerMember(
                    $telegramUser->id,
                    $telegramUser->firstName,
                    $telegramUser->lastName,
                    $telegramChat->id
                );

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