<?php

use App\Livewire\TodoList;
use Illuminate\Support\Facades\Route;

Route::get('/todo', TodoList::class);

