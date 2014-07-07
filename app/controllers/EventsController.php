<?php

use Acme\Category\CategoryRepository;
use Acme\Country\CountryRepository;
use Acme\Event\EventRepository;
use Acme\User\UserRepository;

class EventsController extends BaseController {

    /**
     * @var Acme\Events\EventRepository
     */
    protected $eventRepository;
    /**
     * @var Status
     */
    private $status;
    /**
     * @var Acme\Users\CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var Acme\Users\CountryRepository
     */
    private $countryRepository;
    /**
     * @var Acme\Users\UserRepository
     */
    private $userRepository;

    function __construct(EventRepository $eventRepository, CategoryRepository $categoryRepository, CountryRepository $countryRepository, UserRepository $userRepository)
    {
        $this->eventRepository    = $eventRepository;
        $this->categoryRepository = $categoryRepository;
        $this->countryRepository  = $countryRepository;
        $this->userRepository     = $userRepository;
        parent::__construct();
    }

    public function index()
    {
        $perPage     = 10;
        $this->title = 'Events';
        //find countries,authors,and categories to display in search form
        if ( App::getLocale() == 'en' ) {
            $countries = [0 => Lang::get('site.event.choose_country')] + $this->countryRepository->getAll()->lists('name_en', 'id');
        } else {
            $countries = [0 => Lang::get('site.event.choose_country')] + $this->countryRepository->getAll()->lists('name_ar', 'id');
        }
        $categories = [0 => Lang::get('site.event.choose_category')] + $this->categoryRepository->getEventCategories()->lists('name_en', 'id');
        $authors    = [0 => Lang::get('site.event.choose_author')] + $this->userRepository->getRoleByName('author')->lists('username', 'id');

        // find selected form values
        $search   = trim(Input::get('search'));
        $category = Request::get('category');
        $author   = Request::get('author');
        $country  = Request::get('country');

        // if the form is selected
        // perform search
        if ( ! empty($search) || ! empty($category) || ! empty($author) || ! empty($country) ) {
            $events = $this->eventRepository->getAll()

                ->where(function ($query) use ($search, $category, $author, $country) {
                    if ( ! empty($search) ) {
                        $query->where('title_ar', 'LIKE', "%$search%")
                            ->orWhere('title_en', 'LIKE', "%$search%");
                        //  ->orWhere('description','LIKE',"%$search%")
                        //  ->orWhere('description_en','LIKE',"%$search%");
                    }
                    if ( ! empty($category) ) {
                        $query->where('category_id', $category);
                    }
                    if ( ! empty($author) ) {
                        $query->where('user_id', $author);
                    }
                    if ( ! empty($country) ) {
                        $locations = $this->countryRepository->find($country)->locations()->lists('id');
                        $query->whereIn('location_id', $locations);
                    }
                })->orderBy('date_start', 'ASC')->paginate($perPage);

        } else {
            $events = $this->eventRepository->getEvents($perPage);
        }

        $this->render('site.events.index', compact('events', 'authors', 'categories', 'countries', 'search', 'category', 'author', 'country'));
    }


    public function dashboard()
    {
        // $events = parent::all();
        // get only 4 images for slider
        $events = $this->eventRepository->getSliderEvents();
        $this->render('site.home', compact('events'));
    }

    /**
     * Display the event by Id and the regardig comments.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $event = $this->eventRepository->requireById($id, ['comments', 'author', 'photos', 'subscribers', 'followers', 'favorites']);

        if ( Auth::check() ) {
            $user = Auth::user();
            View::composer('site.events.view', function ($view) use ($id, $user) {

                $favorited  = Favorite::hasFavorited($id, $user->id);
                $subscribed = Subscription::isSubscribed($id, $user->id);
                $followed   = Follower::isFollowing($id, $user->id);

                $view->with(array('favorited' => $favorited, 'subscribed' => $subscribed, 'followed' => $followed));
            });
        } else {
            View::composer('site.events.view', function ($view) {
                $view->with(array('favorited' => false, 'subscribed' => false, 'followed' => false));
            });
        }

        $this->render('site.events.view', compact('event'));

    }

    /* @param eventId $id
     * @return boolean
     * Subscribe an User to the Event
     */
    public function subscribe($id)
    {
        //check whether user logged in
        $user = Auth::user();
        if ( ! empty($user->id) ) {
            $event = $this->eventRepository->findOrFail($id);

            if ( Subscription::isSubscribed($id, $user->id) ) {
                // return you are already subscribed to this event
                return Response::json(array(
                    'success' => false,
                    'message' => Lang::get('site.subscription.already_subscribed', array('attribute' => 'subscribed'))
                ), 400);
            }
            //get available seats
            $available_seats = $this->availableSeats($event);
            // $available_seats = $event->available_seats;
            //check whether seats are empty
            if ( $available_seats >= 1 ) {
                // subscribe this user
                $event->subscriptions()->attach($user);
                //update the event seats_taken colum
                $event->available_seats = $available_seats - 1;
                $event->save();

                return Response::json(array(
                    'success' => true,
                    'message' => Lang::get('site.subscription.subscribed', array('attribute' => 'subscribed'))
                ), 200);
            }

            // notify no seats available
            return Response::json(array(
                'success' => false,
                'message' => Lang::get('site.subscription.no_seats_available')
            ), 400);

        }

        // notify user not authenticated
        return Response::json(array(
            'success' => false,
            'message' => Lang::get('site.subscription.not_authenticated')
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
        $event = $this->eventRepository->findOrFail($id);
        $user  = Auth::user();
        if ( ! empty($user->id) ) {
            if ( Subscription::isSubscribed($event->id, $user->id) ) {
                // check whether user already subscribed
                if ( Subscription::unsubscribe($event->id, $user->id) ) {

                    // reset available seats
                    $event->available_seats = $event->available_seats + 1;
                    $event->save();

                    //delete entry from status
                    $status = $this->status->getStatus($event->id, $user->id);
                    if ( $status ) {
                        $status->delete();
                    }

                    return Response::json(array(
                        'success' => true,
                        'message' => Lang::get('site.subscription.unsubscribed', array('attribute' => 'unsubscribed'))
                    ), 200);

                } else {
                    return Response::json(array(
                        'success' => false,
                        // could not unsubscribe
                        'message' => Lang::get('site.subscription.error', array('attribute' => 'unsubscribe'))
                    ), 500);
                }
            } else {
                // wrong access
                return Response::json(array(
                    'success' => false,
                    'message' => Lang::get('site.subscription.not_subscribed', array('attribute' => 'subscribed'))
                ), 400);
            }
        } else {
            return Response::json(array(
                'success' => false,
                'message' => Lang::get('site.subscription.not_authenticated')
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
        if ( ! empty($user->id) ) {
            //check whether seats are empty
            $event = $this->eventRepository->findOrFail($id);

            if ( Follower::isFollowing($id, $user->id) ) {
                // return you are already subscribed to this event
                return Response::json(array(
                    'success' => false,
                    'message' => Lang::get('site.subscription.already_subscribed', array('attribute' => 'following'))
                ), 400);
            }
            $event->followers()->attach($user);

            return Response::json(array(
                'success' => true,
                'message' => Lang::get('site.subscription.subscribed', array('attribute' => 'following'))
            ), 200);

        }

        // notify user not authenticated
        return Response::json(array(
            'success' => false,
            'message' => Lang::get('site.subscription.not_authenticated')
        ), 403);

    }

    public function unfollow($id)
    {
        //check whether user logged in
        $user = Auth::user();
        if ( ! empty($user->id) ) {
            //check whether seats are empty
            $event = $this->eventRepository->findOrFail($id);

            if ( Follower::isFollowing($id, $user->id) ) {
                // return you are already subscribed to this event

                if ( Follower::unfollow($id, $user->id) ) {
                    return Response::json(array(
                        'success' => true,
                        'message' => Lang::get('site.subscription.unsubscribed', array('attribute' => 'unfollowed'))
                    ), 200);
                } else {
                    return Response::json(array(
                        'success' => false,
                        'message' => Lang::get('site.subscription.error', array('attribute' => 'unfollowing'))
                    ), 500);
                }
            }

            return Response::json(array(
                'success' => false,
                'message' => Lang::get('site.subscription.not_subscribed', array('attribute' => 'following'))
            ), 400);

        }

        // notify user not authenticated
        return Response::json(array(
            'success' => false,
            'message' => Lang::get('site.subscription.not_authenticated')
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
        if ( ! empty($user->id) ) {
            //check whether seats are empty
            $event = $this->eventRepository->findOrFail($id);

            if ( Favorite::hasFavorited($id, $user->id) ) {
                // return you are already subscribed to this event
                return Response::json(array(
                    'success' => false,
                    'message' => Lang::get('site.subscription.already_subscribed', array('attribute' => 'favorited'))
                ), 400);
            }

            $event->favorites()->attach($user);

            return Response::json(array(
                'success' => true,
                'message' => Lang::get('site.subscription.subscribed', array('attribute' => 'favorited'))
            ), 200);

        }

        // notify user not authenticated
        return Response::json(array(
            'success' => false,
            'message' => Lang::get('site.subscription.not_authenticated')
        ), 403);

    }

    public function unfavorite($id)
    {
        //check whether user logged in
        $user = Auth::user();
        if ( ! empty($user->id) ) {
            //check whether seats are empty
            $event = $this->eventRepository->findOrFail($id);

            if ( Favorite::hasFavorited($id, $user->id) ) {
                // return you are already subscribed to this event

                if ( Favorite::unfavorite($id, $user->id) ) {
                    return Response::json(array(
                        'success' => true,
                        'message' => Lang::get('site.subscription.unsubscribed', array('attribute' => 'unfavorited'))
                    ), 200);
                } else {
                    return Response::json(array(
                        'success' => false,
                        'message' => Lang::get('site.subscription.error', array('attribute' => 'unfavorite'))
                    ), 500);
                }
            }

            return Response::json(array(
                'success' => false,
                'message' => Lang::get('site.subscription.not_subscribed', array('attribute' => 'favorited'))
            ), 400);
        }

        return Response::json(array(
            'success' => false,
            'message' => Lang::get('site.subscription.not_authenticated')
        ), 403);

    }

    /**
     * @param object $event
     * @return integer
     */
    protected function availableSeats($event)
    {
        return $event->available_seats;
    }

    public function getSliderEvents()
    {
        // fetch 3 latest post
        // fetches 2 featured post
        // order by event date, date created, featured
        // combines them into one query to return for slider

        $latestEvents   = $this->eventRepository->latestEvents();
        $featuredEvents = $this->eventRepository->feautredEvents();
        $events         = array_merge((array) $latestEvents, (array) $featuredEvents);
        if ( $events ) {
            foreach ( $events as $event ) {
                $array[] = $event->id;
            }
            $events_unique = array_unique($array);
            $sliderEvents  = $this->eventRepository->getSliderEvents(6, $events_unique);

            return $sliderEvents;
        } else {
            return null;
        }

    }

    public function isTheAuthor($user)
    {
        return $this->author_id === $user->id ? true : false;
    }

    public function getAuthor($id)
    {
        $event  = $this->eventRepository->find($id);
        $author = $event->author;

        return $author;
    }


}
