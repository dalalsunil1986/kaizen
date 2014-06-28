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
        $this->beforeFilter('csrf', ['only'=> ['contact']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $contact = $this->contactRepository->getFirst();

        $this->render('site.layouts.contact', compact('contact'));
    }

    /**
     * Send Contact Email.
     *
     * @return Response
     */
    public function contact()
    {
        // Get the contact info from DB
        $user = $this->contactRepository->getFirst();

        // Validate the input data
        $val = $this->contactRepository->getContactForm();

        if ( ! $val->isValid() ) {
            return Redirect::back()->withInput()->with('errors', $val->getErrors());
        }

        $input = array_merge(Input::only(['sender_name','sender_email','body']), $user->toArray());

        Event::fire('contact.contact', [$input]);

        return Redirect::home()->with('success', 'Mail Sent');
    }
}