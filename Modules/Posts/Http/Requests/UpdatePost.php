<?php

namespace Modules\Posts\Http\Requests;

use Modules\Posts\Entities\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdatePost extends StorePost
{
    /**
     * post that will be updates
     *
     * @var \Modules\Posts\Entities\Post
     */
    private $model;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->findPost();
        return $this->model->user_id == $this->user()->id;
    }

    public function findPost()
    {
        if($this->model)
        {
            return $this->model;
        }

        $this->model = Post::find($this->post);
        throw_if(!$this->model, new ModelNotFoundException());
        return $this->model;
    }
}
