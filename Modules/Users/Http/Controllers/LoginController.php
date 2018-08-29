<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Users\Transformers\UserTransformer;

class LoginController extends Controller
{

    public function index(Request $request, UserTransformer $userTransformer)
    {
        if( !auth()->attempt($request->only('email','password')) ){
            return response()->json(
                ['meta' => generate_meta('failure', ['Not Authorized'])],
                401
            );
        }

        if(!($user = auth()->user())->confirmed_at){
            return response()->json(
                ['meta' => generate_meta('failure', ['Your account is not confirmed'])],
                412
            );
        }

        $user->setApiToken(str_random(60));
        $user->loadMedia(['profile_picture', 'cover']);

        return response()->json(
            fractal()
                ->item($user)
                ->transformWith($userTransformer->withEmail())
                ->addMeta(['token' => $user->api_token])
                ->withContentMeta()
                ->toArray(),
            200
        );
    }
}
