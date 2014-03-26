<?php

use Acme\Mail\ContactsMailer;

class ContactsController extends BaseController {

    /**
     * Contact Repository
     *
     * @var Category
     */
    protected $model;

    protected $layout = 'site.layouts.home';
    /**
     * @var Acme\Mail\ContactsMailer
     */
    private $mailer;

    public function __construct(Contact $model, ContactsMailer $mailer)
    {
        $this->model = $model;
        parent::__construct();
        $this->mailer = $mailer;
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $data = Input::all();
        $contact = $this->model->first();
        if($contact) {
            // update
        }
        //save

        $validate = Validator::make($data, $this->model->rules);

	}
}