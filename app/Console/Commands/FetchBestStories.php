<?php

namespace App\Console\Commands;

use App\Models\Story;
use App\Services\HackerNewsService;
use Illuminate\Console\Command;

class FetchBestStories extends Command
{
    protected $signature = 'hn:fetch-best';
    protected $description = 'Fetch best stories from Hacker News';

    public function handle(HackerNewsService $hackerNews)
    {
        $storyIds = $hackerNews->fetchStoryIds('best');
        
        $this->info("Fetching " . count($storyIds) . " best stories...");
        
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
                        'type' => 'best',
                        'text' => $data['text'] ?? null,
                    ]
                );
            }
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Best stories fetched successfully!');
    }
}