<?php

namespace Modules\Posts\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Users\Transformers\UserTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

abstract class LikesController extends Controller
{
    /**
     * model to be liked
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
    public function index(UserTransformer $userTransformer)
    {
        $models = $this->model
                        ->likedBy()
                        ->withMedia('profile_picture')
                        ->paginate(20);
        return response()->json(
            fractal()
                ->collection($models)
                ->transformWith($userTransformer->onlyBasic())
                ->paginateWith(new IlluminatePaginatorAdapter($models))
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
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    public abstract function findModel(Request $request);
}
