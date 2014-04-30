<?php

class AdminBlogsController extends AdminBaseController {


    /**
     * Post Model
     * @var Post
     */
    protected $post;
    /**
     * @var Category
     */
    private $category;
    /**
     * @var User
     */
    private $user;
    /**
     * @var Photo
     */
    private $photo;

    /**
     * Inject the models.
     * @param Post $post
     */
    public function __construct(Post $post,Category $category, User $user, Photo $photo)
    {
        $this->post = $post;
        $this->category = $category;
        $this->user = $user;
        $this->photo = $photo;
        parent::__construct();
        $this->beforeFilter('Admin');
    }

    /**
     * Show a list of all the blog posts.
     *
     * @return View
     */
    public function index()
    {
        // Title
        $title = Lang::get('admin/blogs/title.blog_management');
        // Grab all the blog posts
        $posts = $this->post;
        // Show the page
        return View::make('admin/blogs/index', compact('posts', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Title
        $category = $this->category->getPostCategories()->lists('name', 'id');
        $author = $this->user->getRoleByName('author')->lists('username', 'id');
        $title = Lang::get('admin/blogs/title.create_a_new_blog');

        // Show the page
        return View::make('admin/blogs/create', compact('title','category','author'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        // Validate the inputs

        $validation = new $this->post(Input::except('thumbnail'));
        $validation->slug = Str::slug(Input::get('title'));
        if (!$validation->save()) {
            return Redirect::back()->withInput()->withErrors($validation->getErrors());
        }
        if(Input::hasFile('thumbnail')) {
            // call the attach image function from Photo class
            if(!$this->photo->attachImage($validation->id,Input::file('thumbnail'),'Post','0')) {
                return Redirect::to('admin/blogs/' . $validation->id . '/edit')->withErrors($this->photo->getErrors());
            }
        }
        //update slug
//        $post = $this->post->find($validation->id);
//        $post->slug = Str::slug(Input::get('title'));
//        $post->save();
        return parent::redirectToAdminBlog()->with('success','Added Blog to the Database');
    }

    /**
     * Display the specified resource.
     * @param $id
     * @internal param $post
     * @return Response
     */
    public function show($id)
    {
        // redirect to the frontend
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @internal param $post
     * @return Response
     */
    public function edit($id)
    {
        $title = Lang::get('admin/blogs/title.blog_update');
        $category = $this->category->getPostCategories()->lists('name', 'id');
        $author = $this->user->getRoleByName('author')->lists('username', 'id');
        $post = $this->post->find($id);

        // Show the page
        return View::make('admin/blogs/edit', compact('post', 'title','category','author'));
    }

    /**
     * Update the specified resource in storage.
     * @param $id
     * @internal param $post
     * @return Response
     */
    public function update($id)
    {
        $validation = $this->post->find($id);
        $validation->fill(Input::except('thumbnail'));
        if (!$validation->save()) {
            return Redirect::back()->withInput()->withErrors($validation->getErrors());
        }
        if (Input::hasFile('thumbnail')) {
            if(!$this->photo->attachImage($validation->id,Input::file('thumbnail'),'Post','0')) {
                return Redirect::back()->withErrors($this->photo->getErrors());
            }
        }
        $post = $this->post->find($validation->id);
        $post->slug = Str::slug(Input::get('title'));
        $post->save();
        return parent::redirectToAdminBlog()->with('success','Updated Blog '. $validation->title);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $post
     * @return Response
     */
    public function delete($id)
    {
        dd('h');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @internal param $post
     * @return Response
     */
    public function getDelete($id) {

        $post = $this->post->find($id);
        // Title
        $title = Lang::get('admin/blogs/title.blog_delete');

        // Show the page
        return View::make('admin/blogs/delete', compact('post', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @internal param $post
     * @return Response
     */

    public function destroy($id)
    {
        $post = $this->post->findOrFail($id);
        if ($post->delete()) {
            //  return Redirect::home();
            return parent::redirectToAdminBlog()->with('success','Blog Post Deleted');
        }
        return parent::redirectToAdminBlog()->with('error','Error: Blog Post Not Found');
    }

    /**
     * Show a list of all the blog posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {

        $posts = Post::select(array('posts.id', 'posts.title', 'posts.id as comments', 'posts.created_at'));

        return Datatables::of($posts)

            ->edit_column('comments', '{{ DB::table(\'comments\')->where(\'commentable_id\', \'=\', $id)->where(\'commentable_type\',\'EventModel\')->count() }}')

            ->add_column('actions', '<a href="{{{ URL::to(\'admin/blogs/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/blogs/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>
            ')

            ->remove_column('id')

            ->make();
    }

}