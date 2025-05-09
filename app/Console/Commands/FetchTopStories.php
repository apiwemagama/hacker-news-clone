<?php

namespace App\Console\Commands;

use App\Models\Story;
use App\Services\HackerNewsService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class FetchTopStories extends Command
{
    protected $signature = 'hn:fetch-top';
    protected $description = 'Fetch top stories from Hacker News';

    public function handle(HackerNewsService $hackerNews)
    {
        // Increase execution time limit to 5 minutes
        set_time_limit(300);
        
        $this->info('Starting to fetch top stories...');
        
        $storyIds = $hackerNews->fetchStoryIds('top');
        
        if (empty($storyIds)) {
            $this->error('Failed to fetch story IDs from API');
            return;
        }

        $this->info("Found " . count($storyIds) . " stories. Fetching details...");
        
        $bar = $this->output->createProgressBar(min(30, count($storyIds)));
        $bar->start();

        $successCount = 0;
        
        foreach (array_slice($storyIds, 0, 30) as $index => $storyId) {
            try {
                // Add small delay between requests (100ms)
                if ($index > 0) {
                    usleep(100000);
                }
                
                $data = $hackerNews->fetchItem($storyId);
                
                if ($data && $data['type'] === 'story') {
                    Story::updateOrCreate(
                        ['hn_id' => $data['id']],
                        [
                            'title' => $data['title'] ?? '',
                            'url' => $data['url'] ?? null,
                            'score' => $data['score'] ?? 0,
                            'by' => $data['by'] ?? 'anonymous',
                            'time' => isset($data['time']) 
                                ? Carbon::createFromTimestamp($data['time'])
                                : now(),
                            'type' => 'top',
                            'text' => $data['text'] ?? null,
                        ]
                    );
                    $successCount++;
                }
            } catch (\Exception $e) {
                $this->error("Failed to process story ID {$storyId}: " . $e->getMessage());
            }
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        
        $this->info("Successfully processed {$successCount} top stories");
        $this->info("Memory used: " . memory_get_peak_usage(true)/1024/1024 . " MB");
    }
}