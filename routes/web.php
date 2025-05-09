<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;

Route::get('/', function () {
    return redirect()->route('stories.index', ['type' => 'top']);
});

Route::get('/stories/{type}', [StoryController::class, 'index'])
    ->name('stories.index')
    ->where('type', 'top|new|best');

Route::get('/story/{id}', [StoryController::class, 'show'])
    ->name('stories.show')
    ->where('id', '[0-9]+');