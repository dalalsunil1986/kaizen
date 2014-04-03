<?php

use Illuminate\Support\Facades\URL; # not sure why i need this here :c

class Post extends BaseModel {
    protected $guarded = array();

    public static $rules = array(
        'title'=>'required',
        'content'=>'required'
    );
	/**
	 * Deletes a blog post and all
	 * the associated comments.
	 *
	 * @return bool
	 */
	public function delete()
	{
		// Delete the comments
		$this->comments()->delete();

		// Delete the blog post
		return parent::delete();
	}

	/**
	 * Returns a formatted post content entry,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function content()
	{
		return nl2br($this->content);
	}

	/**
	 * Get the post's author.
	 *
	 * @return User
	 */
    public function author() {
        return $this->belongsTo('User','user_id')->select('id','username','email');
    }


	/**
	 * Get the post's comments.
	 *
	 * @return array
	 */
	public function comments()
	{
		//return $this->hasMany('Comment');
        return $this->morphMany('Comment','commentable');
	}

    public function getDates()
    {
        return array_merge(array(static::CREATED_AT, static::UPDATED_AT, static::DELETED_AT));
    }
	/**
	 * Get the URL to the post.
	 *
	 * @return string
	 */
	public function url()
	{
		return Url::to($this->slug);
	}

	/**
	 * Returns the date of the blog post creation,
	 * on a good and more readable format :)
	 *
	 * @return string
	 */


	/**
	 * Returns the date of the blog post last update,
	 * on a good and more readable format :)
	 *
	 * @return string
	 */


    public function getPresenter()
    {
        return new PostPresenter($this);
    }

    public static function latest($count) {
        return Post::orderBy('created_at', 'DESC')->select('id','title','slug')->remember(10)->limit($count)->get();
    }

    public function  getConsultancies() {
        $query= DB::table('posts')
            ->leftJoin('categories','categories.id','=','posts.category_id')
            ->leftJoin('photos','photos.imageable_id','=','posts.id')
            ->where('photos.imageable_type','=','Post')
            ->where('categories.id','=','5')
            ->paginate();
        return $query;
    }

    public function category() {
//        return $this->morphMany('Category','categorizable','categorizable_type');
        return $this->belongsTo('Category','category_id');
    }
    public function photos() {
        return $this->morphMany('Photo','imageable');
    }
}
