<?php

use Acme\Contact\ContactRepository;

class AdminContactsController extends AdminBaseController {

    /**
     * Contact Repository
     *
     * @var Category
     */
    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->beforeFilter('Admin');
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
        $this->render('admin.contacts.create', compact('contact'));
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

//        $validation = $this->contactRepository->getFirst();
//        if ( ! $validation ) {
//            $validation = new Contact();
//        }

        $contact = $this->contactRepository->getFirst();

        $val = $this->contactRepository->getEditForm($contact->id);

        if ( ! $val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if ( ! $this->contactRepository->update($contact->id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->contactRepository->errors())->withInput();
        }
//
        return Redirect::action('AdminContactsController@index')->with('success', 'Updated');
//
//        // else update
//        $validation->name_en  = Input::get('name_en');
//        $validation->name_ar  = Input::get('name_ar');
//        $validation->address_en  = Input::get('address_en');
//        $validation->address_ar  = Input::get('address_ar');
//        $validation->email    = Input::get('email');
//        $validation->phone    = Input::get('phone');
//        $validation->mobile   = Input::get('mobile');
//        if ( ! $validation->save() ) {
//            return Redirect::back()->withInput()->withErrors($validation->getErrors());
//        }
//
//        return Redirect::action('AdminContactsController@index')->with('success', 'Saved Contact Information');
    }
}