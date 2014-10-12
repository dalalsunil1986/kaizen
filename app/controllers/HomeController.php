<?php

use Acme\Ad\AdRepository;
use Acme\EventModel\EventRepository;

class HomeController extends BaseController {
    /**
     * @var
     */
    private $eventRepository;
    /**
     * @var AdRepository
     */
    private $adRepository;

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
    /**
     * @param EventRepository $eventRepository
     * @param AdRepository $adRepository
     */
    function __construct(EventRepository $eventRepository, AdRepository $adRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->adRepository = $adRepository;
        parent::__construct();
    }

    public function index()
    {
        // $events = parent::all();
        // get only 4 images for slider
        $events  = $this->eventRepository->getSliderEvents();
        $ads = $this->adRepository->getAds();
        $this->render('site.home', compact('events','ads'));

    }

}