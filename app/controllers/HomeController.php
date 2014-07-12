<?php

use Acme\Event\EventRepository;

class HomeController extends BaseController {
    /**
     * @var
     */
    private $eventRepository;

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
    function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
        parent::__construct();
    }


    public function index()
    {
        // $events = parent::all();
        // get only 4 images for slider
        $events  = $this->eventRepository->getSliderEvents();
        $this->render('site.home', compact('events'));
    }

}