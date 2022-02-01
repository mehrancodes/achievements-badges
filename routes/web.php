<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AchievementsController;

Route::get('/users/{user}/achievements', AchievementsController::class)->name('users.achievements.index');
