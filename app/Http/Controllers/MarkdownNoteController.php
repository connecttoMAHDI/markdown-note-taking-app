<?php

namespace App\Http\Controllers;

use App\Models\MarkdownNote;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\CommonMarkConverter;
use Symfony\Component\HttpFoundation\Response;

class MarkdownNoteController extends Controller
{
    /**
     * Retrieves all saved markdown notes with raw markdown.
     *
     * GET /api/v1/notes
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $notes = MarkdownNote::all();

        return $this->successResponse(
            'Notes retrieved successfully.',
            $notes
        );
    }

    /**
     * Create a new Note
     *
     * POST /api/v1/notes
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Check if the request is JSON
        if (! $request->isJson()) {
            return $this->failureResponse(
                'Invalid Content-Type. Please use application/json.'
            );
        }

        // Validate the payload
        $payload = $request->validate([
            'title' => 'required|string|unique:markdown_notes,title',
            'content' => 'required|string',
        ]);

        // Create new note
        $note = MarkdownNote::create($payload);

        // Save the markdown file into storage (storage/app/markdown/)
        $filePath = 'markdown/' . $note->title . '.md';
        Storage::put($filePath, $note->content);

        return $this->successResponse(
            'Note created successfully.',
            $note,
            Response::HTTP_CREATED
        );
    }

    /**
     * Retrieve a single markdown note with raw markdown
     *
     * GET /api/v1/notes/{id}
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(MarkdownNote $note)
    {
        return $this->successResponse(
            'Note retrieved successfully.',
            $note
        );
    }

    /**
     * Render a Note as HTML
     *
     * GET /api/v1/notes/{id}/render
     *
     * @return \Illuminate\Http\JsonResponse|\League\CommonMark\Output\RenderedContentInterface
     */
    public function render(MarkdownNote $note)
    {
        // Locate the .md file in storage
        $filePath = 'markdown/' . $note->title . '.md';

        if (! Storage::exists($filePath)) {
            return $this->failureResponse(
                msg: 'Markdown file not found.',
                statusCode: Response::HTTP_NOT_FOUND
            );
        }

        // Retrieve markdown content
        $markdownContent = Storage::get($filePath);

        // Convert Markdown to HTML
        $converter = new CommonMarkConverter;
        $htmlContent = $converter->convert($markdownContent);

        // Modify the Accept header to render HTML correctly
        request()->headers->set('Accept', 'text/html');

        return $htmlContent;
    }

    /**
     * Uses languagetool API to find any grammatical error on the notes.
     *
     * POST /api/v1/notes/grammar-check
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function grammar_check(Request $request)
    {
        // Check if the request is JSON
        if (! $request->isJson()) {
            return $this->failureResponse(
                'Invalid Content-Type. Please use application/json.'
            );
        }

        // Validate the content
        $payload = $request->validate([
            'markdown' => 'required|string',
        ]);

        // Extract plain text (strip Markdown syntax)
        $plainText = strip_tags((new CommonMarkConverter)
            ->convert($payload['markdown']));

        // Check grammar using LanguageTool API
        $client = new Client;
        $response = $client->post('https://api.languagetool.org/v2/check', [
            'form_params' => [
                'text' => $plainText,
                'language' => 'en-US',
            ],
        ]);

        $grammarCheckResult = json_decode($response->getBody(), true);

        // Transform the raw response into a user-friendly structure
        $userFriendlyResult = [
            'errors' => [],
            'warnings' => [],
        ];

        // Process each match/error
        if (! empty($grammarCheckResult['matches'])) {
            foreach ($grammarCheckResult['matches'] as $match) {
                $matchMsg = $match['shortMessage'];
                $matchSntnce = $match['sentence'];
                $matchOffset = $match['offset'];
                $matchLength = $match['length'];
                $subj = substr($matchSntnce, $matchOffset, $matchLength);
                $suggestions = array_map(
                    function ($replacement) {
                        return $replacement['value'];
                    },
                    $match['replacements'] ?? []
                );
                $userFriendlyResult['errors'][] = [
                    'message' =>  $matchMsg ?? 'Error detected',
                    'original' => $matchSntnce ?? '',
                    'modified' => str_replace($subj, $suggestions[0], $matchSntnce),
                    'subject' => $subj,
                    'offset' => $matchOffset ?? 0,
                    'length' => $matchLength ?? 0,
                    'suggestions' => $suggestions,
                ];
            }
        }

        // If there are any warnings from LanguageTool, pass them along (or process them as needed)
        if (! empty($grammarCheckResult['warnings'])) {
            $userFriendlyResult['warnings'] = $grammarCheckResult['warnings'];
        }

        return $this->successResponse(
            'Grammar check completed.',
            $userFriendlyResult,
            meta: [
                'language' => $grammarCheckResult['language']['name'] ?? 'Unknown',
            ]
        );
    }
}
