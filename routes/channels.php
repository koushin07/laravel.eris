<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Municipality;
use App\Models\Office;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('fires', function ($user) {
    return true;
});

Broadcast::channel('requestSend.{id}', fn ($user, $id) =>  $user->id == $id);

Broadcast::channel('confirmed.{id}', fn ($user, $id) =>  $user->id == $id);

Broadcast::channel('denied.{id}', fn ($user, $id) => $user->id == $id);