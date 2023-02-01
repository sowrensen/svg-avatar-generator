<?php

use Illuminate\Support\Facades\Route;
use Sowren\SvgAvatarGenerator\Http\Controllers\SvgController;

Route::get(config('svg-avatar.url', 'svg-avatar?text='), SvgController::class);
