<?php

class SubscriptionsController extends BaseController {
    protected $model;
    protected $user;
    protected $mailer;
    protected $category;

    function __construct(Subscriptoin $model, User $user, EventModel $event)
    {
        $this->model = $model;
        $this->user = $user;
        $this->event = $event;
        parent::__construct();

    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return View::make('subscriptions.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('subscriptions.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($id)
	{
		//
        return $this->model->save(
            [
                'user_id' => $this->user->getAuthIdentifier(),
                'event_id' => $id
            ]
        );

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return View::make('subscriptions.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('subscriptions.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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

}
