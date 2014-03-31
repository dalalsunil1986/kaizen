<?php

class AdminCategoriesController extends AdminBaseController {

	/**
	 * Category Repository
	 *
	 * @var Category
	 */
	protected $model;

	public function __construct(Category $model)
	{
		$this->model = $model;
        parent::__construct();
        $this->beforeFilter('Admin');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$categories = $this->model->all();

		return View::make('admin.categories.index', compact('categories'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.categories.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $validation = new $this->model(Input::all());
		if (!$validation->save())
		{
            return Redirect::back()->withInput()->withErrors($validation->getErrors());
		}
		return Redirect::home();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$category = $this->model->findOrFail($id);

		return View::make('admin.categories.show', compact('category'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$category = $this->model->find($id);

		if (is_null($category))
		{
			return Redirect::route('admin.categories.index');
		}

		return View::make('admin.categories.edit', compact('category'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
//		$input = array_except(Input::all(), '_method');
//		$validation = Validator::make($input, Category::$rules);
//
//		if ($validation->passes())
//		{
//			$category = $this->model->find($id);
//			$category->update($input);
//
//			return Redirect::to('categories.show', $id);
//		}
//
//		return Redirect::to('categories.edit', $id)
//			->withInput()
//			->withErrors($validation)
//			->with('message', 'There were validation errors.');
        // refer davzie postEdits();
        $validation = $this->model->find($id);
        $validation->fill(Input::all());
        if(!$validation->save()) {
            return Redirect::back()->withInput()->withErrors($validation->getErrors());
        }
        Redirect::route('admin.categories.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->model->find($id)->delete();

		return Redirect::action('AdminCategoriesController@index');
	}


    public function getEvents($id){
        $events = $this->model->find($id)->events;
        return $events;
    }

    public function getPosts($id){
        $posts = $this->model->find($id)->posts;
        return $posts;
    }
}
