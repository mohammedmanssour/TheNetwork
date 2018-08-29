<?php

namespace Modules\Users\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Users\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class FollowersController extends Controller
{
    /**
     * user
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
        $models = $this->user->followers()
                        ->withMedia(['profile_picture', 'cover'])
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

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if(auth()->user()->isFollowing($this->user))
        {
            return response()->json([
                'meta' => generate_meta('failure',['You are following user currently'])
            ], 409);
        }

        auth()->user()->follow($this->user);
        return response()->json([
            'meta' => generate_meta('success')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
        if (!auth()->user()->isFollowing($this->user)) {
            return response()->json([
                'meta' => generate_meta('failure', ['You are not following user currently'])
            ], 409);
        }

        auth()->user()->unfollow($this->user);
        return response()->json([
            'meta' => generate_meta('success')
        ], 200);
    }
}
