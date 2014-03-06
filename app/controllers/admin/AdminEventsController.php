<?php

use Illuminate\Support\Facades\Redirect;

class AdminEventsController extends AdminController {

    protected  $model;

    function __construct(EventModel $model)
    {
        $this->model = $model;
        parent::__construct();

    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
//	public function index()
//	{
//        $events = $this->model->all()->take(5);
//        $events= $this->model->findAll();
//        return $events;
//        return View::make('events.index');
//	}

    public function index()
    {
//        $events =  $this->model->all();
        $events =  parent::all();
        return View::make('events.index', compact('events'));
    }


    /**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('events.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
        $validation = new $this->model(Input::all());
        if(!$validation->save()) {
            return Redirect::back()->withInput()->withErrors($validation->getErrors());
        }
        return Redirect::to('event/'.$validation->id);
	}

	/**
	 * Display the event by Id and the regardig comments.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $event = $this->model->with('comments')->find($id);
        return View::make('events.show',compact('event'));

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $event = $this->model->find($id);
        return View::make('events.edit',compact('event'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

        // refer davzie postEdits();
        $validation = $this->model->find($id);
        $validation->fill(Input::all());
        if(!$validation->save()) {
            return Redirect::back()->withInput()->withErrors($validation->getErrors());
        }
        return Redirect::to('event/'.$id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        if($this->model->findOrFail($id)->delete()) {
//            return Redirect::home();
            return Redirect::to('event/index');

        }

        return Redirect::to('event/index');
	}



}
