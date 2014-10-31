<?php

use Acme\Category\CategoryRepository;
use Acme\Country\CountryRepository;
use Acme\EventModel\EventRepository;
use Acme\Favorite\FavoriteRepository;
use Acme\Follower\FollowerRepository;
use Acme\Package\PackageRepository;
use Acme\Subscription\SubscriptionRepository;
use Acme\User\UserRepository;

class PackagesController extends BaseController {

    /**
     * @var Acme\EventModel\EventRepository
     */
    protected $eventRepository;
    /**
     * @var Status
     */
    private $status;
    /**
     * @var Acme\User\CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var Acme\User\CountryRepository
     */
    private $countryRepository;
    /**
     * @var Acme\User\UserRepository
     */
    private $userRepository;
    /**
     * @var Acme\Subscription\SubscriptionRepository
     */
    private $subscriptionRepository;
    /**
     * @var Acme\Favorite\FavoriteRepository
     */
    private $favoriteRepository;
    /**
     * @var Acme\Follower\FollowerRepository
     */
    private $followerRepository;
    /**
     * @var Acme\Package\PackageRepository
     */
    private $packageRepository;

    function __construct(PackageRepository $packageRepository, EventRepository $eventRepository, CategoryRepository $categoryRepository, CountryRepository $countryRepository, UserRepository $userRepository, SubscriptionRepository $subscriptionRepository, FavoriteRepository $favoriteRepository, FollowerRepository $followerRepository)
    {
        $this->eventRepository    = $eventRepository;
        $this->categoryRepository = $categoryRepository;
        $this->countryRepository  = $countryRepository;
        $this->userRepository     = $userRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->favoriteRepository     = $favoriteRepository;
        $this->followerRepository     = $followerRepository;
        $this->packageRepository = $packageRepository;
        parent::__construct();
    }

    public function index()
    {
        $perPage     = 10;
        $this->title = 'Events';
        //find countries,authors,and categories to display in search form
        if ( App::getLocale() == 'en' ) {
            $countries = [0 => Lang::get('site.choose_country')] + $this->countryRepository->getAll()->lists('name_en', 'id');
        } else {
            $countries = [0 => Lang::get('site.choose_country')] + $this->countryRepository->getAll()->lists('name_ar', 'id');
        }
        $categories = [0 => Lang::get('site.choose_category')] + $this->categoryRepository->getEventCategories()->lists('name_en', 'id');
        $authors    = [0 => Lang::get('site.choose_author')] + $this->userRepository->getRoleByName('author')->lists('username', 'id');

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


    /**
     * Display the event by Id and the regardig comments.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $event = $this->eventRepository->findById($id, ['comments', 'author', 'photos', 'subscribers', 'followers', 'favorites']);
        // Afdal :: the photoRepository is not implemented within EventsController !!!
        $tags       = $this->eventRepository->findById($id)->tags;
        if ( Auth::check() ) {
            $user = Auth::user();
            View::composer('site.events.view', function ($view) use ($id, $user) {

                // getTags related to an Event
                $favorited  = $this->favoriteRepository->hasFavorited($id, $user->id);
                $subscribed = $this->subscriptionRepository->isSubscribed($id, $user->id);
                $followed   = $this->followerRepository->isFollowing($id, $user->id);

                $view->with(array('favorited' => $favorited, 'subscribed' => $subscribed, 'followed' => $followed));
            });
        } else {
            View::composer('site.events.view', function ($view) use ($tags) {
                $view->with(array('favorited' => false, 'subscribed' => false, 'followed' => false));
            });
        }

        $this->render('site.events.view', compact('event','tags'));

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

}
