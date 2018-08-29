<?php

namespace Modules\Comments\Http\Requests;

use Modules\Comments\Entities\Comment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateComment extends StoreComment
{
    /**
     * comment model
     *
     * @var \Modules\Comments\Entities\Comment
     */
    protected $model;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->findModel();
        return $this->model->user_id == $this->user()->id;
    }

    public function findModel()
    {
        $this->model = Comment::find($this->comment);
        throw_if(!$this->model, new ModelNotFoundException());

        return $this->model;
    }
}
