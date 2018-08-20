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

        return response()->json(
            fractal()
                ->item($user)
                ->transformWith($userTransformer)
                ->addMeta(['token' => $user->getRememberToken()])
                ->withContentMeta()
                ->toArray(),
            200
        );
    }
}
