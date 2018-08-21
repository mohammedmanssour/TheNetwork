<?php

namespace Modules\Comments\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Comments\Entities\Comment;
use Modules\Comments\Http\Requests\StoreComment;
use Modules\Comments\Http\Requests\UpdateComment;
use Illuminate\Auth\Access\AuthorizationException;
use Modules\Comments\Transformers\CommentTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class CommentsController extends Controller
{
    /**
     * model to comment on
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function __construct()
    {
        $this->middleware(function($request, $next){
            $this->findModel($request);
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(CommentTransformer $commentTransformer)
    {
        $models = $this->model->comments()->with('user')->paginate(20);

        return response()->json(
            fractal()
                ->collection($models)
                ->transformWith($commentTransformer)
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
    public function store(StoreComment $request, CommentTransformer $commentTransformer)
    {
        return response()->json(
            fractal()
                ->item(
                    $this->model->createComment($request->content)->load('user')
                )
                ->transformWith($commentTransformer)
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
    public function update(UpdateComment $request, CommentTransformer $commentTransformer)
    {
        return response()->json(
            fractal()
                ->item(
                    $this->model->updateComment($request->findModel(), $request->content)
                )
                ->transformWith($commentTransformer)
                ->withContentMeta()
                ->toArray(),
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request)
    {
        $comment = $this->model->comment($request->comment);
        throw_if(
            !$comment,
            new ModelNotFoundException()
        );

        throw_if(
            !auth()->user()->can('delete', [$comment, $this->model]),
            new AuthorizationException()
        );

        $comment->delete();
        return response()->json(
            ['meta' => generate_meta('success')],
            200
        );
    }

    public abstract function findModel(Request $request);
}
