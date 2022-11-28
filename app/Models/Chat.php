<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Chat extends Model
{
    public function chatMembers()
    {
        return $this->hasMany(ChatMember::class);
    }

    public static function registerChat($chat_id)
    {
        DB::table('chats')->insert([
            'chat_id' => $chat_id
        ]);
    }

    public static function unregisterChat($chat_id)
    {
        DB::table('chats')->where('chat_id', '=', $chat_id)->delete();
    }
}