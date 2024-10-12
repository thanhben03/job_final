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
    return (int) $companyId === (int) $user->id;
}, ['guards' => ['company']]);
Broadcast::channel('message.{receiverId}', function ($user, $receiverId) {
    return (int) $receiverId === (int) $user->id;
});
Broadcast::channel('message.company.{receiverId}', function ($user, $receiverId) {
    return (int) $receiverId === (int) Session::get('company')->id;
}, ['guards' => ['company']]);
Broadcast::channel('notification.{receiverId}', function ($user, $receiverId) {
    return $user;
}, ['guards' => ['company', 'web']]);
