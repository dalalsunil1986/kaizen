<?php

class AdminAdsController extends AdminBaseController {


    /**
     * Post Model
     * @var Post
     */
    protected $model;
    /**
     * @var Photo
     */
    protected $photo;

    public function __construct(Ad $model, \Acme\Photo\PhotoRepository $photoRepository)
    {
        $this->model = $model;
        $this->photo = $photoRepository;
        $this->beforeFilter('Admin');
        parent::__construct();
    }

    public function index()
    {
        return View::make('admin.ads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        // if file is uploaded, try to attach it and save it the db
        if ( Input::hasFile('ad1') ) {
            // call the attach image function from Photo class
//            if ( ! $this->photo->attachImage(1, Input::file('ad1'), 'Ad', '0') ) {
//                return Redirect::action('AdminAdsController@index')->withErrors($this->photo->getErrors());
//            }
        }
        if ( Input::hasFile('ad2') ) {
            // call the attach image function from Photo class
            if ( ! $this->photo->attachImage(2, Input::file('ad2'), 'Ad', '0') ) {
                return Redirect::action('AdminAdsController@index')->withErrors($this->photo->getErrors());
            }
        }

        return Redirect::action('AdminAdsController@index')->with('success', 'Added Ads Image to the Database');
    }


}