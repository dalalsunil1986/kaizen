<?php

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class AdminLocationsController extends AdminBaseController {

    protected $model;
    protected $user;
    public function __construct(Location $model, User $user, Country $country) {
        $this->model = $model;
        $this->user = $user;
        $this->country = $country;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $locations = Location::with('country')->get();
        return View::make('admin.locations.index',compact('locations'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $countries = Country::lists('name','id');
        return View::make('admin.locations.create',compact('countries'));
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $validation = new $this->model(Input::all());
        if(!$validation->save()) {
            return Redirect::back()->withInput()->withErrors($validation->getErrors());
        }
        return Redirect::to('admin/locations/'.$validation->id);
        // If validation returns true
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $location = $this->model->findOrFail($id);

        return View::make('admin.locations.show', compact('location'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $location = Location::find($id);
        $countries = $this->country->lists('name','id');
        return View::make('admin.locations.edit',compact('location','countries'));
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
      return Redirect::to('admin/locations/'.$id);
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
        return Redirect::action('AdminLocationsController@index');
	}

    public function getEvents($id){
        $events = Location::find($id)->events;
        return $events;
    }
}
