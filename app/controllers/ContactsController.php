<?php

class ContactsController extends \BaseController {

    /**
     * Contact Repository
     *
     * @var Category
     */
    protected $model;

    protected $layout = 'site.layouts.home';

    public function __construct(Contact $model)
    {
        $this->model = $model;
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
        $contact = $this->model->firstOrFail();
        $this->layout->login = View::make('site.layouts.login');
        $this->layout->ads = view::make('site.layouts.ads');
        $this->layout->nav = view::make('site.layouts.nav');
        $this->layout->maincontent = view::make('site.layouts.contactus', ['contact'=> $contact]);
        $this->layout->sidecontent = view::make('site.layouts.sidebar');
        $this->layout->footer = view::make('site.layouts.footer');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $data = Input::all();
        $contact = $this->model->firstOrFail();
        $validate = Validator::make($data, $this->model->rules);
        $view= 'site.contact-us';
        $subject = 'Kaizen.com - '.$data['name']. ' Has contact you';
        if($validate->passes()) {
            Mail::send($view, $data, function($message) use ($data, $contact, $subject) {
                $message->to('z4ls@live.com')
                        ->subject($subject)
                        ->from($data['email'],$data['name']);
            });
            return Redirect::home();

        } else {
            dd($validate->errors());
        }
	}
}