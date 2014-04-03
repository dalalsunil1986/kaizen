<?php

class BlogController extends BaseController {

    /**
     * Post Model
     * @var Post
     */
    protected $model;

    /**
     * User Model
     * @var User
     */
    protected $user;

    /**
     * Inject the models.
     * @param Post $post
     * @param User $user
     */
    protected $layout = 'site.layouts.home';
    public function __construct(Post $model, User $user)
    {
        parent::__construct();
        $this->model = $model;
        $this->user = $user;
    }
    
	/**
	 * Returns all the blog posts.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Get all the blog posts
        $posts = $this->model->with(array('category','photos','author'))->paginate(10);

//		$posts = parent::all();

		// Show the page
        $this->layout->login = View::make('site.layouts.login');
        $this->layout->ads = view::make('site.layouts.ads');
        $this->layout->nav = view::make('site.layouts.nav');
        $this->layout->maincontent = view::make('site.blog.index', compact('posts'));
        $this->layout->sidecontent = view::make('site.layouts.sidebar');
        $this->layout->footer = view::make('site.layouts.footer');

	}

	/**
	 * View a blog post.
	 *
	 * @param  string  $slug
	 * @return View
	 * @throws NotFoundHttpException
	 */
	public function getView($slug)
	{
		// Get this blog post data
		$post = $this->model->where('slug', '=', $slug)->first();

		// Check if the blog post exists
		if (is_null($post))
		{
			// If we ended up in here, it means that
			// a page or a blog post didn't exist.
			// So, this means that it is time for
			// 404 error page.
			return App::abort(404);
		}
		// Get this post comments
		$comments = $post->comments()->orderBy('created_at', 'ASC')->get();
        // Get current user and check permission
        $user = $this->user->currentUser();
        $canComment = false;
        if(!empty($user)) {
            $canComment = $user->can('post_comment');
        }
		// Show the page
        $this->layout->login = View::make('site.layouts.login');
        $this->layout->ads = view::make('site.layouts.ads');
        $this->layout->nav = view::make('site.layouts.nav');
        $this->layout->maincontent = view::make('site.blog.view', compact('post', 'comments', 'canComment'));
        $this->layout->sidecontent = view::make('site.layouts.sidebar');
        $this->layout->footer = view::make('site.layouts.footer');
	}

	/**
	 * View a blog post.
	 *
	 * @param  string  $slug
	 * @return Redirect
	 */
	public function postView($slug)
	{
        $user = $this->user->currentUser();
        $canComment = $user->can('post_comment');
		if ( ! $canComment)
		{
			return Redirect::to($slug . '#comments')->with('error', 'You need to be logged in to post comments!');
		}

		// Get this blog post data
		$post = $this->model->where('slug', '=', $slug)->first();

		// Declare the rules for the form validation
		$rules = array(
			'comment' => 'required|min:3'
		);

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator->passes())
		{
			// Save the comment
			$comment = new Comment;
			$comment->user_id = Auth::user()->id;
			$comment->content = Input::get('comment');

			// Was the comment saved with success?
			if($post->comments()->save($comment))
			{
				// Redirect to this blog post page
				return Redirect::to($slug . '#comments')->with('success', 'Your comment was added with success.');
			}

			// Redirect to this blog post page
			return Redirect::to($slug . '#comments')->with('error', 'There was a problem adding your comment, please try again.');
		}

		// Redirect to this blog post page
		return Redirect::to($slug)->withInput()->withErrors($validator);
	}

    public function consultancy() {
        $posts=  $this->model
            ->with(array('category','photos','author'))
//            ->leftJoin('categories','categories.id','=','posts.category_id')
//            ->leftJoin('photos','photos.imageable_id','=','posts.id')
//            ->where('photos.imageable_type','=','Post')
            ->where('category_id','=','5')
            ->orderBy('created_at','DESC')
            ->paginate(4);
        $this->layout->login = View::make('site.layouts.login');
//        $this->layout->ads = view::make('site.layouts.ads');
        $this->layout->nav = view::make('site.layouts.nav');
        $this->layout->maincontent = view::make('site.blog.consultancy', compact('posts'));
        $this->layout->sidecontent = view::make('site.layouts.sidebar');
        $this->layout->footer = view::make('site.layouts.footer');
    }
}
