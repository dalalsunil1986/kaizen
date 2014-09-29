<?php

use Acme\Blog\BlogRepository;
use Acme\Category\CategoryRepository;
use Acme\User\UserRepository;

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
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @param BlogRepository $blogRepository
     * @param UserRepository $userRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(BlogRepository $blogRepository, UserRepository $userRepository, CategoryRepository $categoryRepository){

        $this->blogRepository = $blogRepository;
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
        parent::__construct();
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

        $categories = $this->categoryRepository->getPostCategories()->get();
		// Show the page
        $this->render('site.blog.index', compact('posts','categories'));
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
		$post = $this->blogRepository->findById($id,['category','photos','author']);

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
