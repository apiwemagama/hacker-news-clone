<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HackerNewsService
{
    protected $baseUrl = 'https://hacker-news.firebaseio.com/v0/';

    public function fetchStoryIds(string $type): array
    {
        $response = Http::get("{$this->baseUrl}{$type}stories.json");
        
        if ($response->successful()) {
            return $response->json();
        }

        return [];
    }

    public function fetchItem(int $id): ?array
    {
        $response = Http::get("{$this->baseUrl}item/{$id}.json");
        
        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}