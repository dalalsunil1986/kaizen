<?php

use McCool\LaravelAutoPresenter\PresenterInterface;

class Comment extends BaseModel implements PresenterInterface {

    protected $guarded = ['id'];

    protected static  $name ='comment';

    /**
     * Get the comment's author.
     *
     * @return User
     */
    public function author()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function commentable(){
        return $this->morphTo();
    }


    /**
     * Get the comment's post's.
     *
     * @return Blog\Post
     */
    public function post()
    {
        return $this->belongsTo('Post');
    }

    /**
     * Get the post's author.
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function getPresenter()
    {
        return 'Acme\Comment\Presenter';
    }
}
