<?php

namespace Modules\Posts\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Posts\Entities\Post;
use Illuminate\Routing\Controller;
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
                    ->withMedia(['images'])
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
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
