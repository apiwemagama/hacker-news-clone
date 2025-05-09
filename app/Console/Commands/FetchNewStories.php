<?php

namespace App\Console\Commands;

use App\Models\Story;
use App\Services\HackerNewsService;
use Illuminate\Console\Command;

class FetchNewStories extends Command
{
    protected $signature = 'hn:fetch-new';
    protected $description = 'Fetch new stories from Hacker News';

    public function handle(HackerNewsService $hackerNews)
    {
        $storyIds = $hackerNews->fetchStoryIds('new');
        
        $this->info("Fetching " . count($storyIds) . " new stories...");
        
        $bar = $this->output->createProgressBar(count($storyIds));
        $bar->start();

        foreach ($storyIds as $storyId) {
            $data = $hackerNews->fetchItem($storyId);
            
            if ($data && $data['type'] === 'story') {
                Story::updateOrCreate(
                    ['hn_id' => $data['id']],
                    [
                        'title' => $data['title'] ?? '',
                        'url' => $data['url'] ?? null,
                        'score' => $data['score'] ?? 0,
                        'by' => $data['by'] ?? 'anonymous',
                        'time' => $data['time'] ? \Carbon\Carbon::createFromTimestamp($data['time']) : now(),
                        'type' => 'new',
                        'text' => $data['text'] ?? null,
                    ]
                );
            }
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('New stories fetched successfully!');
    }
}