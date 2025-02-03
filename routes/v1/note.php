<?php

use App\Http\Controllers\MarkdownNoteController;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::apiResource('notes', MarkdownNoteController::class)
        ->except('update', 'destroy');
    Route::get('/notes/{id}/render', [MarkdownNoteController::class, 'render'])
        ->name('notes.render');
    Route::post('/notes/grammar-check', [MarkdownNoteController::class, 'grammar_check'])
        ->name('notes.grammar_check');
});
