<?php

namespace App\Http\Controllers\Post;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Post\PostResource;
use App\Http\Requests\posts\StorePostRequest;
use App\Http\Requests\posts\UpdatePostRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request The HTTP request object.
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {

        $posts = Post::whereBelongsTo($request->user())
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->date, function ($query, $date) {
                return $query->whereDate('created_at', $date);
            })
            ->latest()
            ->paginate(10);

        return PostResource::collection(
            $posts
        )->additional([
            'message' => null,
            'status' =>  Response::HTTP_OK,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     * @param StorePostRequest $request
     * @return PostResource|JsonResponse
     */
    public function store(
        StorePostRequest $request
    ): PostResource|JsonResponse {

        try {
            DB::beginTransaction();

            $params = collect($request->validated())
                ->except('platform_id')
                ->toArray();

            $post = $request->user()->posts()->create($params);

            $post->platforms()->attach($request->validated('platform_id'));

            DB::commit();

            return PostResource::make(
                $post->load('user')
            )->additional([
                'message' => 'Post created successfully',
                'status' => Response::HTTP_CREATED,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to create post',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     * @param  Post $post
     * @return PostResource
     */
    public function show(
        Post $post
    ): PostResource {
        return PostResource::make(
            $post->load('user')
        )->additional([
            'message' => 'Post fetched successfully',
            'status' => Response::HTTP_OK,
        ]);
    }


    /**
     * Update the specified resource in storage.
     * @param UpdatePostRequest $request
     * @param  Post $post
     * @return PostResource|JsonResponse
     */
    public function update(
        UpdatePostRequest $request,
        Post $post
    ): PostResource|JsonResponse {

        try {

            DB::beginTransaction();

            $params = collect($request->validated())
                ->except('platform_id')
                ->toArray();

            $post->update($params);

            $post->platforms()->sync($request->validated('platform_id'));

            DB::commit();

            return PostResource::make(
                $post->load('user')
            )->additional([
                'message' => 'Post updated successfully',
                'status' => Response::HTTP_OK,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to update post',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Post $post
     */
    public function destroy(
        Post $post
    ): JsonResponse {
        try {
            DB::beginTransaction();

            $post->delete();

            DB::commit();

            return response()->json([
                'message' => 'Post deleted successfully',
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to delete post',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Restore the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function restore(
        int $id
    ): JsonResponse {   

        try {

            $post = Post::withTrashed()->findOrFail($id);

            if (!$post->trashed()) {
                return response()->json([
                    'message' => 'Post is not deleted.',
                    'status' => 400,
                ], 400);
            }

            DB::beginTransaction();

            $post->restore();

            DB::commit();

            return response()->json([
                'message' => 'Post restored successfully',
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to restore post',
                'error' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
