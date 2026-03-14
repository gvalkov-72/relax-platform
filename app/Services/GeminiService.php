<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1';
    protected $model = 'gemini-2.5-flash'; // за generateContent
    protected $embeddingModel = 'text-embedding-004'; // нов модел за embeddings

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
    }

    public function generateContent($prompt, $temperature = 0.7)
    {
        $url = "{$this->baseUrl}/models/{$this->model}:generateContent?key={$this->apiKey}";
        
        $response = Http::post($url, [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ],
            'generationConfig' => [
                'temperature' => $temperature,
                'maxOutputTokens' => 2048,
            ]
        ]);

        if ($response->failed()) {
            Log::error('Gemini API грешка: ' . $response->body());
            return null;
        }

        $candidates = $response->json('candidates');
        if (empty($candidates)) {
            Log::error('Gemini API: няма candidates', $response->json());
            return null;
        }

        return $candidates[0]['content']['parts'][0]['text'] ?? null;
    }

    public function createEmbedding($text)
    {
        $url = "{$this->baseUrl}/models/{$this->embeddingModel}:embedContent?key={$this->apiKey}";
        
        $response = Http::post($url, [
            'content' => ['parts' => [['text' => $text]]],
        ]);

        if ($response->failed()) {
            Log::error('Gemini embedding грешка: ' . $response->body());
            return null;
        }

        return $response->json('embedding.values');
    }

    public function generateStructured($prompt, $schema)
    {
        $fullPrompt = $prompt . "\n\nВърни само JSON в следния формат:\n" . json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
        $response = Http::post("{$this->baseUrl}/models/{$this->model}:generateContent?key={$this->apiKey}", [
            'contents' => [
                ['parts' => [['text' => $fullPrompt]]]
            ],
            'generationConfig' => [
                'temperature' => 0.2,
                'maxOutputTokens' => 2048,
            ]
        ]);

        if ($response->failed()) {
            Log::error('Gemini structured грешка: ' . $response->body());
            return null;
        }

        $text = $response->json('candidates.0.content.parts.0.text');
        return $this->extractJson($text);
    }

    private function extractJson($text)
    {
        if (!$text) return null;
        preg_match('/\{.*\}/s', $text, $matches);
        if (isset($matches[0])) {
            return json_decode($matches[0], true);
        }
        return null;
    }
}