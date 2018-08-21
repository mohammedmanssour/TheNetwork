<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Users\Transformers\UserTransformer;

class UserController extends Controller
{
    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(UserTransformer $userTransformer)
    {
        return response()->json(
            fractal()
                ->item(
                    auth()->user()->loadMedia(['profile_picture', 'cover'])
                )
                ->transformWith($userTransformer)
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
    public function update(Request $request)
    {
    }
}
