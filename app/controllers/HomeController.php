<?php

use Acme\Events\EloquentEventRepository;

class HomeController extends BaseController {
    /**
     * @var
     */
    private $repository;

    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |	Route::get('/', 'HomeController@showWelcome');
    |
    */
    function __construct(EloquentEventRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }


    public function index()
    {
        // $events = parent::all();
        // get only 4 images for slider
        $events  = $this->repository->getSliderEvents();
        $this->render('site.home', compact('events'));
    }

}