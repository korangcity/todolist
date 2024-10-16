<?php

use Illuminate\Support\Facades\Broadcast;

//Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
//});

Broadcast::channel('addTask', function () {
    return true;
});

Broadcast::channel('updateTask', function () {
    return true;
});

Broadcast::channel('deleteTodo', function () {
    return true;
});

Broadcast::channel('change-todo-status', function () {
    return true;
});



