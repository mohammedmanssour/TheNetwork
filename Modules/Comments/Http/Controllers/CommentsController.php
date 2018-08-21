<?php

namespace Modules\Comments\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

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
    public function index()
    {
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

    public abstract function findModel(Request $request);
}
