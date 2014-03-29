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
        if($validation) {
            $validation->username;
            $validation->address;
            $validation->email;
            $validation->phone;
            $validation->mobile;
            //update
        } else {
            $validation = new Photo();
            $validation=Input::get('username');
            $validation=Input::get('address');
            $validation=Input::get('email');
            $validation=Input::get('phone');
            $validation=Input::get('mobile');
        }

        if(!$validation->save()) {
            return Redirect::back()->withInput()->withErrors($validation->getErrors());
        }
        return parent::redirectToAdmin()->with('success','Saved Contact Information');

	}
}