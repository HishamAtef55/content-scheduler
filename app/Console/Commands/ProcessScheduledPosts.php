<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Post;
use App\Enums\Status;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessScheduledPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:publish';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Publish posts that are due based on their scheduled_at timestamp';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $duePosts = Post::whereNotNull('scheduled_at')
            ->whereDate('scheduled_at', '<=', now())
            ->get();

        if ($duePosts->isEmpty()) {
            $this->info('No posts due for publication.');
            return ;
        }

        foreach ($duePosts as $post) {
            $this->publishPost($post);
        }


    }

    /**
     * publishPost
     * @param Post $post
     * @return void
     */

    protected function publishPost(
    Post $post
    ):void
    {
        // Mock publishing
        try {

            $post->update([
                'published_at' => Carbon::now()->toDayDateTimeString(),
                'status' => Status::PUBLISHED->value,
            ]);

            Log::info("Post published: {$post->title} at " . now()->toDateTimeString());
            
        } catch (\Exception $e) {

            Log::error("Failed to publish post: {$post->title}. Error: {$e->getMessage()}");

            $this->error("Failed to publish post: {$post->title}");
            
        }
    }
}
