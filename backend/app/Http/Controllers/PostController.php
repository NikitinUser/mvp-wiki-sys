<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Transformers\Request\PostRequestTransformer;
use App\Jobs\UpdatePostJob;
use App\Services\CreatePostActionMediator;
use App\Services\PostServie;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class PostController extends Controller
{
    private PostRequestTransformer $postRequestTransformer;

    private CreatePostActionMediator $createPostActionMediator;
    private PostServie $postServie;

    public function __construct(
        PostRequestTransformer $postRequestTransformer,
        CreatePostActionMediator $createPostActionMediator,
        PostServie $postServie
    ) {
        $this->postRequestTransformer = $postRequestTransformer;
        $this->createPostActionMediator = $createPostActionMediator;
        $this->postServie = $postServie;
    }

    /**
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        try {
            $postsData = $this->postServie->getAll();
            return response()->json($postsData, 200);
        } catch (Throwable $t) {
            Log::error($t->getTraceAsString());
            return response()->json($t->getMessage(), 500);
        }
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function getById(int $id): JsonResponse
    {
        try {
            $postData = $this->postServie->getById($id);
            return response()->json($postData, 200);
        } catch (Throwable $t) {
            Log::error($t->getTraceAsString());
            return response()->json($t->getMessage(), 500);
        }
    }

    /**
     * @param CreatePostRequest $request
     *
     * @return JsonResponse
     */
    public function create(CreatePostRequest $request): JsonResponse
    {
        try {
            $dto = $this->postRequestTransformer->createPostTrasform($request->validated());
            $result = $this->createPostActionMediator->createPost($dto);
            return response()->json($result, 200);
        } catch (Throwable $t) {
            Log::error($t->getTraceAsString());
            return response()->json($t->getMessage(), 500);
        }
    }

    /**
     * @param UpdatePostRequest $request
     *
     * @return JsonResponse
     */
    public function update(UpdatePostRequest $request): JsonResponse
    {
        try {
            $dto = $this->postRequestTransformer->updatePostTrasform($request->validated());
            UpdatePostJob::dispatch($dto)->onQueue('updating_post');
            return response()->json();
        } catch (Throwable $t) {
            Log::error($t->getTraceAsString());
            return response()->json($t->getMessage(), 500);
        }
    }
}
