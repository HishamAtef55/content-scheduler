<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class RestrictPostException extends Exception
{
    /**
     * Report the exception.
     */
    public function report(): void
    {
        Log::warning("RestrictPostException: {$this->getMessage()}");
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        Log::warning("Post limit exceeded for user " . ($request->user()->id ?? 'unknown') . ": {$this->getMessage()}");
        return response()->json([
            'message' => 'You have reached the daily limit of 10 scheduled posts. Please try again tomorrow.',
            'status' => 429,
        ], 429);
    }
}