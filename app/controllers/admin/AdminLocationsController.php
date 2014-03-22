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
//        return View::make('locations.index');
	    return Location::all();
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

//        $user = $this->user->currentUser();
//        $user = Auth::user();
//        $canComment = false;
//        if(!$user) {
//            echo 'Hey You are not logged in Brah';
//        }
//        if (!$user->can('post_comment')) {
//            echo 'Hey You cannot Post Comment Brah';
//        } else {
//            echo 'You can Post Comment' .$user->username;
//        }
//        echo '<br>';
//        if($user->hasRole('admin')) {
//            echo 'Hey u have comment';
//        }
        $countries = Country::lists('name','id');
        return View::make('locations.create',compact('countries'));
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
        return Redirect::to('locations/'.$validation->id);
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
        return $this->model->find($id);
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
        return View::make('locations.edit',compact('location','countries'));
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
      return Redirect::to('locations/'.$id);
    }



    /**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

    public function getEvents($id){
        $events = Location::find($id)->events;
        return $events;
    }
}
