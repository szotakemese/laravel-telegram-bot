<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChatMember extends Model
{
    public function chats()
    {
        return $this->belongsTo(Chat::class);
    }

    public static function registerMember($user_id, $first_name, $last_name, $chat_id)
    {
        DB::table('chat_members')->insert([
            'user_id' => $user_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'chat_id' => $chat_id
        ]);
    }

    public static function unregisterMember($user_id)
    {
        DB::table('chat_members')->where('user_id', '=', $user_id)->delete();
    }

    public static function getRandomPairs($chat_id)
    {
        $members = DB::table('chat_members')
            ->where('chat_id', '=', $chat_id)
            ->inRandomOrder()
            ->get();
    }
}