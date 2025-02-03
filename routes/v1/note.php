<?php

use App\Http\Controllers\MarkdownNoteController;
use App\Http\Middleware\AcceptJsonMiddleware;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::apiResource('notes', MarkdownNoteController::class)
        ->except('update', 'destroy');
    Route::get('/notes/{note}/render', [MarkdownNoteController::class, 'render'])
        ->name('notes.render')
        ->withoutMiddleware(AcceptJsonMiddleware::class);
    Route::post('/notes/grammar-check', [MarkdownNoteController::class, 'grammar_check'])
        ->name('notes.grammar_check');
});
