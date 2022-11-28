<?php

namespace App\Bot\Commands;

use App\Models\Chat;
use App\Models\ChatMember;
use Telegram\Bot\Commands\Command;
use Illuminate\Support\Facades\DB;

class GenerateCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "generate";

    /**
     * @var string Command Description
     */
    protected $description = "Generate Command to select coffee pairs";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $telegramUpdate = $this->getUpdate();
        $telegramChat = $telegramUpdate->getChat();

        $membersNumber = DB::table('chat_members')
            ->where('chat_id', '=', $telegramChat->id)
            ->count();

        if($membersNumber >= 2)
            try {
                ChatMember::getRandomPairs($telegramChat->id);

                // This will send a message using `sendMessage` method behind the scenes to
                // the user/chat id who triggered this command.
                // `replyWith<Message|Photo|Audio|Video|Voice|Document|Sticker|Location|ChatAction>()` all the available methods are dynamically
                // handled when you replace `send<Method>` with `replyWith` and use the same parameters - except chat_id does NOT need to be included in the array.
                $this->replyWithMessage(['text' => 'Done']);
            } catch (\Exception $exception) {
                $this->replyWithMessage(['text' => "Oops... Something went wrong. {$exception->getMessage()}"]);
            }
        else
            $this->replyWithMessage(['text' => "Number of members is less than two"]);    
    }
}