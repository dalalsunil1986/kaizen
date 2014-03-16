<?php

class CommentsController extends BaseController {

	/**
	 * Category Repository
	 *
	 * @var Category
	 */
	protected $model;
    /**
     * @var Event
     */
    private $event;

    public function __construct(Comment $model, EventModel $event)
	{
		$this->model = $model;
        $this->event = $event;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    /**
     * Store a newly created resource in storage.
     *
     * @param $id
     * @return Response
     */
	public function store($id)
	{
        $event = $this->event->find($id);
        $validation = Validator::make(Input::all(),Comment::getRules());
        if(!$validation->passes()) {
            return Redirect::to(LaravelLocalization::localizeURL('event/'.$id))->withInput()->withErrors($validation->errors());
        } else {
            $data = array();
            $data['content'] = Input::get('content');
            $data['user_id'] = Auth::user()->getAuthIdentifier();
            $event->comments()->create($data);
        }
        return Redirect::to('event/'.$id);
	}
}
