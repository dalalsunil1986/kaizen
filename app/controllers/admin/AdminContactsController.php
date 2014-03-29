<?php

use Acme\Mail\ContactsMailer;

class AdminContactsController extends BaseController {

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
        $this->mailer = $mailer;
        parent::__construct();
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $contact = $this->model->first();
        return View::make('admin.contacts.create',compact('contact'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
//        $validation = $this->model->firstOrNew(Input::except('_token'));
//        $validation->fill(Input::all());
//        if(!$validation->save()) {
//            return Redirect::back()->withInput()->withErrors($validation->getErrors());
//        }
//        return parent::redirectToAdmin()->with('success','Saved Contact Information');

        $validation = $this->model->first();
        if(!$validation) {
            //if no records, create one
            $validation = new Contact();
        }
        // else update
        $validation->username  =Input::get('username');
        $validation->address  =Input::get('address');
        $validation->email  =Input::get('email');
        $validation->phone  =Input::get('phone');
        $validation->mobile  =Input::get('mobile');
        if(!$validation->save()) {
            return Redirect::back()->withInput()->withErrors($validation->getErrors());
        }
        return parent::redirectToAdmin()->with('success','Saved Contact Information');
	}
}