<?php

namespace Modules\Posts\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Posts\Entities\Post;

class PostsLikesController extends LikesController
{
    public function findModel(Request $request)
    {
        $this->model = Post::find($request->post);
        throw_if(!$this->model, new ModelNotFoundException);
        return $this->model;
    }
}
