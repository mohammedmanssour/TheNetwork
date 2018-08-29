<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Users\Http\Requests\UpdateUser;
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
                ->transformWith($userTransformer->withEmail())
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
    public function update(UpdateUser $request, UserTransformer $userTransformer)
    {
        $user = auth()->user();

        $user->fill(
            $request->transformed()
        )->save();

        $user->syncMedia($request->profile_picture, 'profile_picture');
        $user->syncMedia($request->cover, 'cover');

        return response()->json(
            fractal()
            ->item($user)
            ->transformWith($userTransformer->withEmail())
            ->withContentMeta()
            ->toArray(),
            200
        );
    }
}
