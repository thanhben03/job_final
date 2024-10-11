<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Session;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('appointment.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
Broadcast::channel('appointment.company.{companyId}', function ($user, $companyId) {
    return (int) $companyId === (int) Session::get('company')->id;
});
