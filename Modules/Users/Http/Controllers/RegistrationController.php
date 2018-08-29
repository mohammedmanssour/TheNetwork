<?php

namespace Modules\Users\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Users\Http\Requests\StoreUser;
use Modules\Users\Events\NewUserRegistered;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function store(StoreUser $request)
    {
        event(
            new NewUserRegistered(
                User::create(
                    $request->transformed()
                )->confirmed()
            )
        );
        return response()->json(['meta' => generate_meta('success')], 200);
    }
}
