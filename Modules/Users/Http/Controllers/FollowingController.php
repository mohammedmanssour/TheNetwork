<?php

namespace Modules\Users\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Users\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class FollowingController extends Controller
{
    /**
     * User
     *
     * @var \App\User
     */
    protected $user;

    public function __construct()
    {
        $this->middleware(function($request, $next){
            $this->user = User::find($request->user);
            throw_if(!$this->user, new ModelNotFoundException());
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(UserTransformer $userTransformer)
    {
        $models = $this->user
                        ->following()
                        ->paginate(20);

        return response()->json(
            fractal()
                ->collection($models)
                ->transformWith($userTransformer)
                ->paginateWith(new IlluminatePaginatorAdapter($models))
                ->withContentMeta()
                ->toArray(),
            200
        );
    }
}
