<?php

namespace Modules\Posts\Traits;

use Modules\Posts\Entities\Post;

trait HasPosts{

    /*----------------------------------------------------
    * Relationships
    --------------------------------------------------- */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /*----------------------------------------------------
    * methods
    --------------------------------------------------- */
    /**
     * create new post and assign it to user
     *
     * @param array $data
     * @return \Modules\Posts\Entities\Post
     */
    public function createPost($data)
    {
        $post = $this->posts()
                    ->create($data);

        if(isset($data['images'])){
            $post->syncMedia($data['images'], 'images');
        }

        return $post;
    }
}