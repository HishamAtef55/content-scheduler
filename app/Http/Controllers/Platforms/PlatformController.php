<?php

namespace App\Http\Controllers\Platforms;

use App\Models\Platform;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PostAnalyticsService;
use App\Http\Resources\PlatForm\PlatFormResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PlatformController extends Controller
{

    public function __construct(
        private readonly PostAnalyticsService $postAnalyticsService
    )
    {
        
    }

    /**
     * Display a listing of the resource.
     * @param AnonymousResourceCollection
     */
    public function index():AnonymousResourceCollection
    {
        $platforms = Platform::with(['posts' => function ($q) {
            $q->select('posts.id', 'status');
        }])->get();

        return PlatFormResource::collection(
           $platforms
        )->additional([
            'message' => null,
            'status' => 200,
            'analytics' => $this->postAnalyticsService->handle($platforms),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
