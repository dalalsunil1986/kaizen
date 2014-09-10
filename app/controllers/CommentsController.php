<?php

use Acme\Comment\CommentRepository;
use Acme\EventModel\EventRepository;

class CommentsController extends BaseController {

	/**
	 * Category Repository
	 *
	 * @var Category
	 */
	protected $commentRepository;
    /**
     * @var Event
     */
    private $eventRepository;

    public function __construct(CommentRepository $commentRepository, EventRepository $eventRepository)
	{
		$this->commentRepository = $commentRepository;
        $this->eventRepository = $eventRepository;
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
//        $event = $this->event->find($id);
//        $validation = Validator::make(Input::all(),Comment::getRules());
//        if(!$validation->passes()) {
//            return Redirect::to('event/'.$id)->withInput()->withErrors($validation->errors());
//        } else {
//            $data = array();
//            $data['content'] = Input::get('content');
//            $data['user_id'] = Auth::user()->getAuthIdentifier();
//            $event->comments()->create($data);
//        }
//        return Redirect::to('event/'.$id);

        $event = $this->eventRepository->findById($id);

        $val = $this->commentRepository->getCreateForm();

        if ( ! $val->isValid() ) {
            return Redirect::back()->withInput()->withErrors($val->getErrors());
        }

        if ( ! $record = $event->comments()->create(array_merge(['user_id'=>Auth::user()->id],$val->getInputData())) ) {
            return Redirect::back()->with('errors', $this->commentRepository->errors())->withInput();
        }

        return Redirect::action('EventsController@show',$id)->with('success','Category Created');
	}
}
