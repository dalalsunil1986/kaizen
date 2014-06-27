<?php

use Acme\Contact\ContactRepository;

class ContactsController extends BaseController {

    /**
     * Contact Repository
     *
     * @var Category
     */
    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
        parent::__construct();
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $contact = $this->contactRepository->getFirst();

        dd($contact->toArray());

        $this->render('site.layouts.contact', compact('contact'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function contact()
	{
        $user = $this->contactRepository->first();
            if($this->mailer->sendMail($user,$args)) {
                return Redirect::home()->with('success','Mail Sent');
            }
            return Redirect::home()->with('error','Error Sending Mail');

        return Redirect::back()->withInput()->with('error',$validate->errors()->all());

	}
}