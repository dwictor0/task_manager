<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat', function () {
    return true;
});



Broadcast::channel('usuario.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

