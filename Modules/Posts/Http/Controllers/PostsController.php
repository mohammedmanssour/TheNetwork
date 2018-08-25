<?php

namespace Modules\Posts\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Posts\Entities\Post;
use Illuminate\Routing\Controller;
use Modules\Posts\Http\Requests\StorePost;
use Modules\Posts\Http\Requests\DeletePost;
use Modules\Posts\Http\Requests\UpdatePost;
use Modules\Posts\Transformers\PostTransformer;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(PostTransformer $postTransformer)
    {
        $models = Post::with('user')
                    ->with('user.media')
                    ->withMedia(['images'])
                    ->withCount('comments')
                    ->when(request('source') == 'feed', function($query){
                        $query->fromFeed();
                    })
                    ->paginate(20);

        return response()->json(
            fractal()
                ->collection($models)
                ->transformWith($postTransformer)
                ->withContentMeta()
                ->toArray(),
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(StorePost $request, PostTransformer $postTransformer)
    {
        $post = auth()->user()->createPost($request->validated());

        return response()->json(
            fractal()
                ->item(
                    $post->load('user')->load('user.media')->loadMedia('images')
                )
                ->transformWith($postTransformer)
                ->withContentMeta()
                ->toArray(),
            200
        );
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(Post $post, PostTransformer $postTransformer)
    {
        $post->load('user')->load('user.media')->loadMedia(['images']);

        return response()->json(
            fractal()
                ->item($post)
                ->transformWith($postTransformer)
                ->withContentMeta()
                ->toArray(),
            200
        );
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UpdatePost $request, PostTransformer $postTransformer)
    {
        ($post = $request->findPost())
            ->fill($request->validated())
            ->save();
        $post->syncMedia($request->images, 'images');

        return response()->json(
            fractal()
                ->item(
                    $post->load('user')->load('user.media')->loadMedia('images')
                )
                ->transformWith($postTransformer)
                ->withContentMeta()
                ->toArray(),
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(DeletePost $request)
    {
        $request->findPost()->delete();

        return response()->json(
            ['meta' => generate_meta('success')],
            200
        );
    }
}
