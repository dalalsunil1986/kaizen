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
	public function contact()
	{
        $args = Input::all();
        $rules = array(
            'email'=>'required|email',
            'name'=>'required',
            'comment'=>'required|min:5'
        );
        $user = $this->model->first();
        $validate = Validator::make($args,$rules);
        if($validate->passes()) {
            if($this->mailer->sendMail($user,$args)) {
                return Redirect::home()->with('success','Mail Sent');
            }
            return Redirect::home()->with('error','Error Sending Mail');
        }
        return Redirect::back()->withInput()->with('error',$validate->errors()->all());

	}
}