<?php

use Acme\Mail\EventsMailer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class EventsController extends BaseController
{

    protected $model;
    protected $user;
    protected $mailer;
    protected $category;
    protected $photo;
    protected $currentTime;


    function __construct(EventModel $model, User $user, EventsMailer $mailer, Category $category, Photo $photo)

    {
        $this->model = $model;
        $this->user = $user;
        $this->mailer = $mailer;
        $this->category = $category;
        $this->photo = $photo;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    // master layout
    protected $layout = 'site.layouts.home';

    public function index()
    {
        $perPage = 10;
        //find countries,authors,and categories to display in form
        $categories = $this->category->getEventCategories()->lists('name', 'id');
        $authors = $this->user->getRoleByName('author')->lists('username', 'id');
        $countries = Country::all()->lists('name','id');

        // find selected form values
        $search = trim(Input::get('search'));
        $category = Request::get('category');
        $author = Request::get('author');
        $country = Request::get('country');
        $this->currentTime = Carbon::now()->toDateTimeString();

        // if the form is selected
        // perform search
        if(!empty($search) || !empty($category) || !empty($author) || !empty($country)) {


            $events = $this->model->with('category')->
                where('date_start','>',$this->currentTime)->
                where(function($query) use ($search, $category, $author, $country)
                {
                    if (!empty($search)) {
                        $query->where('title','LIKE',"%$search%");
                        //  ->orWhere('title_en','LIKE',"%$search%")
                        //  ->orWhere('description','LIKE',"%$search%")
                        //  ->orWhere('description_en','LIKE',"%$search%");
                    }
                    if (!empty($category)) {
                        $query->where('category_id', $category);
                    }
                    if (!empty($author)) {
                        $query->where('user_id', $author);
                    }
                    if (!empty($country)) {
                        $locations = Country::find($country)->locations()->get(array('id'));
                        foreach($locations as $location) {
                            $location_id[] = $location->id;
                        }
                        $location_array = implode(',',$location_id);
                        $query->whereRaw('location_id in ('.$location_array.')');
                    }
                })->orderBy('date_start', 'DESC')->paginate($perPage);

        } else {
            $events = $this->getEvents($perPage);
        }

        // get only 4 images for slider
        //**Usama**
        //each section is divided like widgets ...
        // so flixable to add/remove slider
        // add/remove ads section
        // add/remove login form section .. and so on
//        $this->layout->events = View::make('site.layouts.event', ['events'=>$events]); // slider section
        $this->layout->login = View::make('site.layouts.login');
        $this->layout->nav = view::make('site.layouts.nav');
        // $this->layout->slider = view::make('site.layouts.event', ['events' => $events] );
        $this->layout->maincontent = view::make('site.events.index', compact('events','authors','categories','countries','search','category','author','country'));
        $this->layout->sidecontent = view::make('site.layouts.sidebar');
        $this->layout->footer = view::make('site.layouts.footer');

    }

    /**
     * Display the event by Id and the regardig comments.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $event =  EventModel::with('comments','author','photos','subscribers','followers','favorites')->find($id);
        // dd($event);
        //return View::make('events.show', compact('event'));
        $this->layout->login = View::make('site.layouts.login');
        $this->layout->ads = view::make('site.layouts.ads');
        $this->layout->nav = view::make('site.layouts.nav');
        $this->layout->maincontent = view::make('site.layouts.eventmain' , ['event' => $event]);
        $this->layout->sidecontent = view::make('site.layouts.sidecontent');
        $this->layout->footer = view::make('site.layouts.footer');
    }

    public function slider()
    {
        //        $events = parent::all();
        // get only 4 images for slider
        $events = $this->getSliderEvents();
        //**Usama**
        //each section is divided like widgets ...
        // so flixable to add/remove slider
        // add/remove ads section
        // add/remove login form section .. and so on

        $this->layout->events = View::make('site.layouts.event',compact('events')); // slider section
        $this->layout->login = View::make('site.layouts.login');
        $this->layout->ads = view::make('site.layouts.ads');
        $this->layout->nav = view::make('site.layouts.nav');
        $this->layout->slider = view::make('site.layouts.event',compact('events') );
        $this->layout->maincontent = view::make('site.layouts.dashboard');
        $this->layout->sidecontent = view::make('site.layouts.sidebar');
        $this->layout->footer = view::make('site.layouts.footer');

        View::composer('site.layouts.ads', function($view)
        {
            $ad1 = Ad::getAd1();
            $ad2 = Ad::getAd2();
            $view->with(array('ad1'=>$ad1,'ad2'=>$ad2));
        });

    }

    /**
     * @param eventId $id
     * @return boolean
     * Subscribe an User to the Event
     */
    public function subscribe($id)
    {
        //check whether user logged in
        $user = Auth::user();
        if (!empty($user->id)) {
            //check whether seats are empty
            $event = $this->model->findOrFail($id);

            if (Subscription::isSubscribed($id,$user->id)) {
                // return you are already subscribed to this event
                return Response::json(array(
                    'success' => false,
                    'message'=> 'you have already subscribed to this event'
                ), 400 );
            }

            $available_seats = $this->availableSeats($event);
            // $available_seats = $event->available_seats;
            if ($available_seats >= 1) {
                // subscribe this user
                $event->subscriptions()->attach($user);
                //update the event seats_taken colum
                $event->available_seats = $available_seats - 1;
                $event->save();
                return Response::json(array(
                    'success' => true,
                    'message'=> 'you have been subscribed'
                ), 200);

            }
            // notify no seats available
            return Response::json(array(
                'success' => false,
                'message'=> 'No seats available'
            ), 400);

        }
        // notify user not authenticated
        return Response::json(array(
            'success' => false,
            'message'=> 'You are not Authenticated'
        ), 401);

    }


    /**
     * @param $id eventId
     * @return boolean true false
     * Unsubscribe a User from an event
     */
    public function unsubscribe($id)
    {
        // check whether user authenticated
        $event = $this->model->findOrFail($id);
        $user = Auth::user();
        if (!empty($user->id)) {
            if (Subscription::isSubscribed($event->id,$user->id)) {
                // check whether user already subscribed
                if (Subscription::unsubscribe($event->id,$user->id)) {

                    // reset available seats
                    $event->available_seats = $event->available_seats + 1;
                    $event->save();
                    return Response::json(array(
                        'success' => true,
                        'message'=> 'You have been unsubscribed'
                    ), 200);

                } else {
//                    dd(' Error : Could not Unsubscribe You ');
                    return Response::json(array(
                        'success' => false,
                        'message'=> ' Error : Could not Unsubscribe You '
                    ), 500);
                }
            } else {
                // wrong access
                return Response::json(array(
                    'success' => false,
                    'message'=> 'sorry wrong access, you have\'nt subscribed in first place'
                ), 400);
            }
        } else {
            return Response::json(array(
                'success' => false,
                'message'=> 'you are not authenticated'
            ), 403);
        }

    }

    /**
     * @param $id eventId
     * @return boolean
     * User to Follow an Event
     */
    public function follow($id)
    {
        //check whether user logged in
        $user = Auth::user();
        if (!empty($user->id)) {
            //check whether seats are empty
            $event = $this->model->findOrFail($id);

            if (Follower::isFollowing($id,$user->id)) {
                // return you are already subscribed to this event
                return Response::json(array(
                    'success' => false,
                    'message'=> 'you are already following this event'
                ), 400);
            }

            $event->followers()->attach($user);
            return Response::json(array(
                'success' => true,
                'message'=> 'you are following now'
            ), 200);

        }
        // notify user not authenticated
        return Response::json(array(
            'success' => false,
            'message'=> 'You are not Authenticated'
        ), 403);

    }

    public function unfollow($id)
    {
        //check whether user logged in
        $user = Auth::user();
        if (!empty($user->id)) {
            //check whether seats are empty
            $event = $this->model->findOrFail($id);

            if (Follower::isFollowing($id,$user->id)) {
                // return you are already subscribed to this event

                if(Follower::unfollow($id,$user->id)) {
                    return Response::json(array(
                        'success' => true,
                        'message'=> 'you are  not following this event anymore '
                    ), 200);
                } else {
                    return Response::json(array(
                        'success' => false,
                        'message'=> 'Error : Could not Unfavorite You'
                    ), 500);
                }
            }
            return Response::json(array(
                'success' => false,
                'message'=> 'you havent followed this event in first place'
            ), 400);

        }
        // notify user not authenticated
        return Response::json(array(
            'success' => false,
            'message'=> 'You are not Authenticated'
        ), 403);

    }

    /**
     * @param $id eventId
     * @return boolean
     * User to Follow an Event
     */
    public function favorite($id)
    {
        //check whether user logged in
        $user = Auth::user();
        if (!empty($user->id)) {
            //check whether seats are empty
            $event = $this->model->findOrFail($id);

            if (Favorite::hasFavorited($id,$user->id)) {
                // return you are already subscribed to this event
                return Response::json(array(
                    'success' => false,
                    'message'=> 'you have already favorited this event'
                ), 400);
            }

            $event->favorites()->attach($user);
            return Response::json(array(
                'success' => true,
                'message'=> 'you favorited this event'
            ), 200);

        }
        // notify user not authenticated
        return Response::json(array(
            'success' => false,
            'message'=> 'You are not Authenticated'
        ), 403);

    }

    public function unfavorite($id)
    {
        //check whether user logged in
        $user = Auth::user();
        if (!empty($user->id)) {
            //check whether seats are empty
            $event = $this->model->findOrFail($id);

            if (Favorite::hasFavorited($id,$user->id)) {
                // return you are already subscribed to this event

                if(Favorite::unfavorite($id,$user->id)) {
                    return Response::json(array(
                        'success' => true,
                        'message'=> 'You unfavorited this event'
                    ), 200);
                } else {
                    return Response::json(array(
                        'success' => false,
                        'message'=> 'Error : Could not Unfavorite You '
                    ), 500);
                }
            }
            return Response::json(array(
                'success' => false,
                'message'=> 'you havent favorited this event in first place'
            ), 400);
        }
        return Response::json(array(
            'success' => false,
            'message'=> 'You are not Authenticated'
        ), 403);

    }

    /**
     * @param object $event
     * @return integer
     */
    protected function availableSeats($event)
    {
        //        $total_seats = $event->total_seats;
        ////        dd($total_seats);
        //        $seats_taken = $event->subscriptions->count();
        //        dd($seats_taken);
        //
        //        $available_seats = $total_seats - $seats_taken;
        //        // $available_seats = $seats_taken;
        //        // dd($available_seats);
        //        return $available_seats->getAvailableSeats();
        return $event->available_seats;

    }

    public function getSliderEvents()
    {
        // fetch 3 latest post
        // fetches 2 featured post
        // order by event date, date created, featured
        // combines them into one query to return for slider

        $latestEvents = $this->model->latestEvents();
        $featuredEvents = $this->model->feautredEvents();
        $events  = array_merge((array)$latestEvents,(array)$featuredEvents);
        foreach ($events as $event) {
            $array[] = $event->id;
        }
        $events_unique = array_unique($array);
        $sliderEvents = $this->model->getSliderEvents(5,$events_unique);
        return $sliderEvents;

    }

    public function isTheAuthor($user)
    {
        return $this->author_id === $user->id ? true : false;
    }

    public function getAuthor($id)
    {
        $event = $this->model->find($id);
        $author = $event->author;
        dd($author);
    }

    public function search() {

        $perPage = 5;
        //find countries,authors,and categories to display in form
        $categories = $this->category->getEventCategories()->lists('name', 'id');
        $authors = $this->user->getRoleByName('author')->lists('username', 'id');
        $countries = Country::all()->lists('name','id');

        // find selected form values
        $search = trim(Input::get('search'));
        $category = Request::get('category');
        $author = Request::get('author');
        $country = Request::get('country');

        // if the form is selected
        // perform search
        if(!empty($search) || !empty($category) || !empty($author) || !empty($country)) {

            $events = $this->model->with('category')->where(function($query) use ($search, $category, $author, $country)
            {
                if (!empty($search)) {
                    $query->where('title','LIKE',"%$search%");
                    //  ->orWhere('title_en','LIKE',"%$search%")
                    //  ->orWhere('description','LIKE',"%$search%")
                    //  ->orWhere('description_en','LIKE',"%$search%");
                }
                if (!empty($category)) {
                    $query->where('category_id', $category);
                }
                if (!empty($author)) {
                    $query->where('user_id', $author);
                }
                if (!empty($country)) {
                    $locations = Country::find($country)->locations()->get(array('id'));
                    foreach($locations as $location) {
                        $location_id[] = $location->id;
                    }
                    $location_array = implode(',',$location_id);
                    $query->whereRaw('location_id in ('.$location_array.')');
                }
            })->orderBy('date_start', 'DESC')->paginate($perPage);

        } else {
            $events = $this->getEvents($perPage);
        }

        $this->layout->login = View::make('site.layouts.login');
        $this->layout->ads = view::make('site.layouts.ads');
        $this->layout->nav = view::make('site.layouts.nav');
        //$this->layout->slider = view::make('site.layouts.event', ['events' => $events] );
        $this->layout->maincontent = view::make('site.events.search', compact('events','authors','categories','countries','search','category','author','country'));
        $this->layout->sidecontent = view::make('site.layouts.sidebar');
        $this->layout->footer = view::make('site.layouts.footer');
    }

    public function getEvents($perPage) {
        return $this->model->with('category')->where('date_start','>',$this->currentTime)->orderBy('date_start','DESC')->paginate($perPage);
    }

}
