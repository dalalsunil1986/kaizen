<?php

use Acme\Blog\BlogRepository;
use Acme\Users\UserRepository;

class BlogsController extends BaseController {

    protected $model;
    /**
     * @var Acme\Blog\BlogRepository
     */
    private $blogRepository;
    /**
     * @var Acme\Users\UserRepository
     */
    private $userRepository;

    public function __construct(BlogRepository $blogRepository, UserRepository $userRepository){

        $this->blogRepository = $blogRepository;
        $this->userRepository = $userRepository;
    }
    
	/**
	 * Returns all the blog posts.
	 *
	 * @return View
	 */
	public function index()
	{
		// Get all the blog posts
        $posts = $this->blogRepository->getAllPaginated(['category','photos','author']);

		// Show the page
        $this->render('site.blog.index', compact('posts'));
	}

    /**
     * View a blog post.
     *
     * @param $id
     * @internal param string $slug
     * @return View
     */
	public function show($id)
	{
		// Get this blog post data
		$post = $this->blogRepository->requireById($id,['category','photos','author']);

        $this->render('site.blog.view', compact('post'));
	}

    /**
     * Get Posts For Consultancies
     */
    public function consultancy() {
        $posts=  $this->blogRepository->getConsultancyPosts();

        $this->render('site.blog.consultancy', compact('posts'));
    }
}
