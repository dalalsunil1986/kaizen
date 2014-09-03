<?php

class TagsController extends BaseController {



    public $eventModel;
    private $tag;

    // Dependent Injection Patter - object of EventModel
    public function __construct(EventModel $eventModel, Tag $tag) {
    $this->eventModel = $eventModel;
    $this->tag = $tag;
    parent::__construct();
    }
    /**
	 * Display a listing of the resource.
	 * GET /tags
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /tags/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /tags
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /tags/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
        $tag =  $this->tag->find($id);
        $latest_event_posts = $this->eventModel->latest(4);

        $events = $tag->events()->paginate(15);
        View::composer('site.events.index', function ($view) use ($tag) {
            $view->with(array('favorited' => false, 'subscribed' => false, 'followed' => false, 'tags'=> $tag));
        });
        $this->render('site.events.index', compact('events', 'latest_event_posts'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /tags/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /tags/{id}
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
	 * DELETE /tags/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}