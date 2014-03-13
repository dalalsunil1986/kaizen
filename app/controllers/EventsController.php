<?php

use Acme\Mail\EventsMailer;
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
        $events = parent::all();
        // get only 4 images for slider
        //**Usama**
        //each section is divided like widgets ...
        // so flixable to add/remove slider
        // add/remove ads section
        // add/remove login form section .. and so on
//        $this->layout->events = View::make('site.layouts.event', ['events'=>$events]); // slider section

        $this->layout->nav = view::make('site.layouts.nav');
//        $this->layout->slider = view::make('site.layouts.event', ['events' => $events] );
        $this->layout->maincontent = view::make('site.layouts.allevents', ['events'=> $events]);
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
        // $this->layout->events = View::make('site.layouts.event', ['events'=>$events]); // slider section
        $this->layout->login = View::make('site.layouts.login');
        $this->layout->ads = view::make('site.layouts.ads');
        $this->layout->nav = view::make('site.layouts.nav');
        $this->layout->slider = view::make('site.layouts.event', ['events' => $events] );
        $this->layout->maincontent = view::make('site.layouts.maincontent');
        $this->layout->sidecontent = view::make('site.layouts.sidecontent');
        $this->layout->footer = view::make('site.layouts.footer');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $category = $this->category->getEventCategories()->lists('name', 'id');
        $author = $this->user->getRoleByName('author')->lists('username', 'id');
        $location = Location::all()->lists('name', 'id');
        $country = Country::all()->lists('name', 'id');
        return View::make('events.create', compact('category', 'author', 'location'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //validate and save
        $validation = new $this->model(Input::except('thumbnail'));
        if (!$validation->save()) {
            return Redirect::back()->withInput()->withErrors($validation->getErrors());
        }
        // if file is uploaded, try to attach it and save it the db
        if(Input::hasFile('thumbnail')) {
            // call the attach image function from Photo class
            if(!$this->photo->attachImage($validation->id,Input::file('thumbnail'),'EventModel','1')) {
                return Redirect::to(LaravelLocalization::localizeURL('event/' . $validation->id . '/edit'))->withErrors($this->photo->getErrors());
            }
        }
        return Redirect::to('event/' . $validation->id);
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

        if (Auth::check()) {
            $user = Auth::user();
            View::composer('site.layouts.eventmain', function($view) use ($id, $user)
            {
                $favorited =  Favorite::hasFavorited($id,$user->id);
                $subscribed = Subscription::isSubscribed($id,$user->id);
                $followed = Follower::isFollowing($id,$user->id);
                $view->with(array('favorited'=>$favorited,'subscribed'=>$subscribed,'followed'=>$followed));

            });
        } else {
            View::composer('site.layouts.eventmain', function($view)
            {
                $view->with(array('favorited'=>false,'subscribed'=>false,'followed'=>false));
            });
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        {
            $event = $this->model->find($id);
            $category = $this->category->getEventCategories()->lists('name', 'id');
            $author = $this->user->getRoleByName('author')->lists('username', 'id');
            $location = Location::all()->lists('name', 'id');
            $country = Country::all()->lists('name', 'id');
            return View::make('events.edit', compact('event', 'category', 'author', 'location'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        // refer davzie postEdits();
        $validation = $this->model->find($id);
        $validation->fill(Input::except('thumbnail'));
        if (!$validation->save()) {
            return Redirect::back()->withInput()->withErrors($validation->getErrors());
        }
        if (Input::hasFile('thumbnail')) {
            if(!$this->photo->attachImage($validation->id,Input::file('thumbnail'),'EventModel','0')) {
                return Redirect::back()->withErrors($this->photo->getErrors());
            }
        }
        return Redirect::to('event/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->model->findOrFail($id)->delete()) {
            //  return Redirect::home();
            return Redirect::to('event/index');
        }
        return Redirect::to('event/index');
    }


    /**
     * @param $id
     * @return statement
     * Send Notification Email for the Event Followers
     */

    public function notifyFollowers($id)
    {
        $event = $this->model->find($id);

//        dd($user);
        Notify::lessonSubscribers($event);
//        return $this->mailer->notifyFollowers($event);
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

            if (Subscription::isSubscribed($id)) {
                // return you are already subscribed to this event
//                dd('you have already subscribed to this event');
                return Response::json(array(
                    'success' => false,
                    'message'=> 'you have already subscribed to this event'
                ), 400 );
            }
            // either call availableSeats function which caluclated the total space available or
            // just query the events table available_seats column

            $available_seats = $this->availableSeats($event);
            // $available_seats = $event->available_seats;
            if ($available_seats >= 1) {
                // check whether this user is already subscriber

                // subscribe this user
                $event->subscriptions()->attach($user);
                //update the event seats_taken colum
                $event->available_seats = $available_seats - 1;
                $event->save();
//                dd('you have been registered');
                return Response::json(array(
                    'success' => true,
                    'message'=> 'you have been registered'
                ), 200);

            }
            // notify no seats available
//            dd('No seats availble');
            return Response::json(array(
                'success' => false,
                'message'=> 'No seats availblet'
            ), 400);

        }
        // notify user not authenticated
//        dd('You are not Authenticated');
        return Response::json(array(
            'success' => false,
            'message'=> 'You are not Authenticated'
        ), 401);

    }


    /**
     * @param $id eventId
     * return boolean true false
     * Unsubscribe a User from an event
     */
    public function unsubscribe($id)
    {
        // check whether user authenticated
        $event = $this->model->find($id);
        $user = Auth::user();
        if (!empty($user->id)) {
            if (Subscription::isSubscribed($id)) {
                // check whether user already subscribed
                if (Subscription::unsubscribe($id)) {
//                    dd('You have been unsubscribed' );
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
//                dd('sorry wrong access, you have\'nt subscribed in first place');
                return Response::json(array(
                    'success' => false,
                    'message'=> 'sorry wrong access, you have\'nt subscribed in first place'
                ), 400);
            }
            // reset available seats
            $event->available_seats = $event->available_seats + 1;
            $event->save();
        } else {
//            dd('you are not authenticated');
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
//                dd('you are already following this event');
                return Response::json(array(
                    'success' => false,
                    'message'=> 'you are already following this event'
                ), 400);
            }

            $event->followers()->attach($user);

//            dd('you are following');
            return Response::json(array(
                'success' => true,
                'message'=> 'you are following now'
            ), 200);

        }
        // notify user not authenticated
//        dd('You are not Authenticated');
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
//                    'you are  not following this event anymore ';
                    return Response::json(array(
                        'success' => true,
                        'message'=> 'you are  not following this event anymore '
                    ), 200);
                } else {
//                 } : ' Error : Could not Unfavorite You ';
                    return Response::json(array(
                        'success' => false,
                        'message'=> 'Error : Could not Unfavorite You'
                    ), 500);
                }
                // redriect user
            }
            return Response::json(array(
                'success' => false,
                'message'=> 'you havent followed this event in first place'
            ), 400);

        }
        // notify user not authenticated
//        dd('You are not Authenticated');
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
//                dd('you have already favorited this event');
                return Response::json(array(
                    'success' => false,
                    'message'=> 'you have already favorited this event'
                ), 400);
            }

            $event->favorites()->attach($user);

//            dd('you favorited this event');
            return Response::json(array(
                'success' => true,
                'message'=> 'you favorited this event'
            ), 200);

        }
        // notify user not authenticated
//        dd('You are not Authenticated');
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
//                    dd('You unfavorited this event');
                    return Response::json(array(
                        'success' => true,
                        'message'=> 'You unfavorited this event'
                    ), 200);
                } else {
//                     dd(' Error : Could not Unfavorite You ') ;
                    return Response::json(array(
                        'success' => false,
                        'message'=> 'Error : Could not Unfavorite You '
                    ), 500);
                }
            }
//            dd('you havent favorited this event in first place');
            return Response::json(array(
                'success' => false,
                'message'=> 'you havent favorited this event in first place'
            ), 400);
        }
        // notify user not authenticated
//        dd('You are not Authenticated');
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
        $total_seats = $event->total_seats;
        //dd($total_seats);
        $seats_taken = $event->subscriptions->count();
        // dd($event->subscriptions);

        $available_seats = $total_seats - $seats_taken;
        // $available_seats = $seats_taken;
        // dd($available_seats);
        return $available_seats;
        // notify no seats left

    }

    public function getSliderEvents()
    {
        // get 4 events
        // with images
        return $this->model->featured()->get(array('e.id','e.title','e.title_en','e.description','e.description_en','p.name'));
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
        //search by country
        //search by location
        //search by category
        //search by instructor name
        $event = parent::all();
        $this->layout->login = View::make('site.layouts.login');
        $this->layout->ads = view::make('site.layouts.ads');
        $this->layout->nav = view::make('site.layouts.nav');
        //$this->layout->slider = view::make('site.layouts.event', ['events' => $events] );
        $this->layout->maincontent = view::make('site.layouts.allevents', ['events' => $event, 'search'=>true]);
        $this->layout->sidecontent = view::make('site.layouts.sidecontent');
        $this->layout->footer = view::make('site.layouts.footer');

//        $categories = $this->category->getEventCategories()->lists('name', 'id');
//        $authors = $this->user->getRoleByName('author')->lists('username', 'id');
//        $countries = Country::all()->lists('name', 'id');
//        $general = // will search for the word in any field of the table !!!!
//
//        $search = Request::get('search');
//        $category = Request::get('category');
//        $author = Request::get('author');
//        $country = Request::get('country');
//
//        $events = $this->model;
//        {
//            if (isset($getSearch)) {
//                $events = $events->where('title','LIKE',"%$search%");
////                $events = $events->orWhere('description','LIKE',"%$getSearch%");
//
//            }
//            if (isset($category)) {
//                $events = $events->where('category_id',$category);
//            }
//
//        };
//
//        $events = $events->get( array('title'));
//
////        $events = DB::table('events')->where(function($query) use ($getSearch, $getCategory, $getAuthor, $getCountry)
////        {
////            if (isset($getSearch)) {
////                $query->where('title','LIKE',"%$getSearch%")
////                    ->orWhere('description','LIKE',"%$getSearch%");
////            }
////            if (isset($getCategory)) {
////                $query->where('category_id', '=', $getCategory);
////            }
////        })->get( array('title','description') );
//
//
////        $best_circle = DB::table("member_circles")
////            ->select("circle_id", DB::raw("COUNT(*)"))
////            ->join("member_relations", function($join) use ($user){
////                $join->on("member_circles.member_id", "=", "member_relations.member_b")
////                    ->where("member_a", "=", $user->member_id)
////                    ->where("active", "=", "1");
////            });
////
//
////        $events = DB::table('events')
////            ->select("events.title");
////            if(isset($getSearch)) {
////                ->where('title' ,'LIKE', "%$getSearch%")
////                ->orWhere('description','LIKE',"%$getSearch%");
////            }
////            if(isset($getCategory)) {
////                ->leftJoin('categories','id','=',$getCategory);
////            }
////        ;
//
//
////        DB::table('node')
////            ->where(function($query) use ($published, $year)
////            {
////                if ($published) {
////                    $query->where('published', 'true');
////                }
////
////                if (!empty($year) && is_numeric($year)) {
////                    $query->where('year', '>', $year);
////                }
////            })
////            ->get( array('column1','column2') );
//
//
//
////        $events = $this->model->where(function($query) use ($getSearch,$getCategory,$getAuthor,$getCountry) {
////            if(!empty($getSearch)) {
////                $query->where('title','LIKE',"%$getSearch%")
////                      ->orWhere('description','LIKE',"%$getSearch%");
////            }
////            if(!empty($getCategory)) {
////                $query->where(
////                $query->join("categories", function ($join) use($getCategory) {
////                    $join->on("categories.id", '=', "%$getCategory%");
////                }));
////            }
////        })->get();
//
//        return View::make('events.search',compact('category','author','country','events','search','categories','authors','countries'));
    }

}
