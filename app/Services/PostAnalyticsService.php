<?php

namespace App\Services;

use App\Enums\Status;
use App\Models\Platform;
use Illuminate\Database\Eloquent\Collection;

class PostAnalyticsService
{

    /**
     * Handle the analysis of posts.
     *
     * @param Collection $posts
     * @return array
     */

    public function handle(Collection $platforms): array
    {
        return $platforms->map(function (Platform $platform) {

            $posts = $platform->posts;

            return [
                'platform_id' => $platform->id,
                'platform_name' => $platform->name,
                'analytics' => $this->getAnalytics($posts),
            ];
            
        })->toArray();
    }


    /**
     * getAnalytics
     *
     * @param Collection $posts
     * @return array
     */

    private function getAnalytics(Collection $posts): array
    {
        $totalPosts = $this->getTotalPosts($posts);
        $publishedCount = $this->getPostsCountByStatus($posts, Status::PUBLISHED);
        $scheduledCount = $this->getPostsCountByStatus($posts, Status::SCHEDULED);
        $draftCount = $this->getPostsCountByStatus($posts, Status::DRAFT);

        return [
                'count' => $totalPosts,
                'published_count' => $publishedCount,
                'scheduled_count' => $scheduledCount,
                'draft_count' => $draftCount,
                'rate_of_published' => $this->getRate($publishedCount, $totalPosts),
                'rate_of_scheduled' => $this->getRate($scheduledCount, $totalPosts),
                'rate_of_draft' => $this->getRate($draftCount, $totalPosts),
        ];
    }

    /**
     * Get the total number of posts.
     *
     * @param Collection $posts
     * @return int
     */
    private function getTotalPosts(Collection $posts): int
    {
        return $posts->count();
    }

    /**
     * Get the number of posts for a specific status.
     *
     * @param Collection $posts
     * @param mixed $status
     * @return int
     */
    private function getPostsCountByStatus(Collection $posts, $status): int
    {
        return $posts->where('status', $status)->count();
    }

    /**
     * Calculate the rate (percentage) of posts for a given count and total.
     *
     * @param int $count
     * @param int $total
     * @return float
     */
    private function getRate(int $count, int $total): float
    {
        return $total > 0 ? round(($count / $total) * 100, 2) : 0;
    }
}