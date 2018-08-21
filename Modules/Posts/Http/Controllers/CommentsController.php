<?php

namespace Modules\Posts\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Posts\Entities\Post;
use Illuminate\Routing\Controller;
use \Modules\Comments\Http\Controllers\CommentsController as BaseComments;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommentsController extends BaseComments
{
    /**
     * find related model
     *
     * @param \Illuminate\Http\Request $request
     */
    public function findModel(Request $request)
    {
        $this->model = Post::find($request->post);
        throw_if(!$this->model, new ModelNotFoundException());
    }
}
