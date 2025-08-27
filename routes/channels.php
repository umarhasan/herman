<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{id}', function ($user, $id) {
    // Allow listening only if the authenticated user id matches channel id
    return (int) $user->id === (int) $id;
});
