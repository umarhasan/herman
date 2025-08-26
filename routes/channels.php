<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Chat;


Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    return Chat::where('id', $chatId)
        ->where(function ($q) use ($user) {
            $q->where('teacher_id', $user->id)
              ->orWhere('student_id', $user->id);
        })->exists();



});
