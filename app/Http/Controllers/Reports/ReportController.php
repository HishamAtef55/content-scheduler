<?php

namespace App\Http\Controllers\Reports;

use App\Models\Post;
use App\Models\Platform;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PostAnalysisService;
use App\Services\PostAnalyticsService;

class ReportController extends Controller
{

    public function __construct(public PostAnalyticsService $postAnalysisService)
    {
       
    }


    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $platforms = Platform::with(['posts' => function ($q) {
            $q->select('posts.id', 'status');
        }])->get();
        
        return response()->json([
            'posts' => [
               'data' => $this->postAnalysisService->handle($platforms),
            ],

            'status' => 200,
        ]);
    }
}
