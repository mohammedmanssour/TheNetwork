<?php
namespace Modules\Comments\Traits;

use Modules\Comments\Entities\Comment;

trait HasComments{

    public function comments()
    {
        return $this->morphMany(
            Comment::class,
            'commentable',
            'model_type',
            'model_id'
        );
    }

    /*----------------------------------------------------
    * methods
    --------------------------------------------------- */
    /**
     * create new comment
     *
     * @param string $content
     * @return \Modules\Comments\Entities\Comment
     */
    public function createComment($content)
    {
        return $this->comments()->create([
                'content' => $content,
                'user_id' => auth()->user()->id
            ]);
    }

    /**
     * update comment
     *
     * @param \Modules\Comments\Entities\Comment $comment
     * @param string $content
     * @return \Modules\Comments\Entities\Comment
     */
    public function updateComment(Comment $comment, $content)
    {
        $comment->fill(['content' => $content]);
        $this->comments()->save($comment);
        return $comment;
    }

    /**
     * delete comment
     *
     * @param integer|\Modules\Comments\Entities\Comment $comment
     * @return void
     */
    public function deleteComment($comment)
    {
        if($comment instanceof Comment){
            $comment = $comment->id;
        }

        $this->comments()->where('id', $comment)->delete();
    }

    /**
     * get comment from $id
     *
     * @param integer $id
     * @return \Modules\Comments\Entities\Comment
     */
    public function comment($id)
    {
        return $this->comments()->where('id', $id)->first();
    }

}