<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Reports\ReportController;
use App\Http\Controllers\Profile\ProfileController;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;
use App\Http\Controllers\Platforms\PlatformController;

require __DIR__ . '/auth.php';


Route::middleware(['auth:sanctum'])->group(function () {


    Route::prefix('profile')->name('profile.')->group(function () {
        Route::controller(ProfileController::class)->group(function () {
            Route::get('me', 'show')->name('show');
        });
    });

    Route::post('posts/{post}/restore', [PostController::class, 'restore'])->name('posts.restore');

    Route::middleware(['throttle:10,1440'])->group(function () {
        Route::apiResource('posts', PostController::class)->only(['store']);
    });
    Route::apiResource('posts', PostController::class)->except(['store']);


    Route::apiResource('platforms', PlatformController::class);

});

