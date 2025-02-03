<?php

namespace Database\Seeders;

use App\Models\MarkdownNote;
use Illuminate\Database\Seeder;

class MarkDownNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MarkdownNote::create([
            'title' => 'Basic Markdown Formatting',
            'content' => '# My First Note
                This is a **bold** text and this is *italic*.

                ## Subheading
                - Item 1
                - Item 2
                - Item 3

                [Click here](https://example.com) to visit a website.
            ',
        ]);
        MarkdownNote::create([
            'title' => 'Markdown with Code Blocks',
            'content' => '# Code Block Example
                Here is some PHP code:

                ```php
                <?php
                echo "Hello, World!";
                ?>
            ',
        ]);
        MarkdownNote::create([
            'title' => 'Markdown with Images',
            'content' => '# Image Test
                This is an image:

                ![Laravel Logo](https://laravel.com/img/logomark.min.svg)
            ',
        ]);
        MarkdownNote::create([
            'title' => 'Nested Lists & Blockquotes',
            'content' => '# Nested List & Quote Test
                - Item 1
                - Subitem 1.1
                - Subitem 1.2
                    - Subitem 1.2.1
                - Item 2

                > This is a blockquote.
            ',
        ]);
    }
}
