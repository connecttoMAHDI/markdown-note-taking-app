<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarkdownNoteController extends Controller
{
    public function index()
    {
        // Retrieves all saved markdown notes with raw markdown.
    }

    public function store()
    {
        // Saves a markdown note after grammar verification.
    }

    public function show()
    {
        // Fetches a specific markdown note with raw markdown.
    }

    public function render()
    {
        // Converts markdown content to HTML.
    }

    public function grammar_check()
    {
        // Accepts markdown text, extracts plain text, and checks grammar.
    }
}
