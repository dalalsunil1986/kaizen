<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/**
 * route group for localized url
 */
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::group(
    array(
        'prefix' => LaravelLocalization::setLocale(), // default : English === it will set the local language according to the session
        'before' => 'LaravelLocalizationRedirectFilter' // LaravelLocalization filter
        // only forces lang /ar/en to the URL
        // first time to load english !!! so it will force the before filter to en
    ),
    function()
    {
        /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
        Route::get('/', function()
        {

            Event::listen('illuminate.query', function($sql)
            {
                echo '<pre>';
                print_r($sql . "\n");
                echo '</pre>';
            });
//            $user = Auth::user();
//            $query = Subscription::where('user_id', "=", $user->id)->where('event_id', "=", '2');
//            $event = EventModel::findOrFail(35);
//            $query = $event->photos->toArray();
//            $event = EventModel::all();
//            $query = $event->photos->toArray();
//            $query = User::with('roles')->whereHas('roles', function($q)
//            {
//                $q->where('name', '=', 'author');
//
//            })->get()->toArray();

//            $query = Role::with('users')->whereHas('users', function($q)
//            {
//                $q->where('name', '=', 'author');
//
//            })->get()->toArray();
//            $query = EventModel::featured()->get(array('e.id','e.title','e.title_en','e.description','e.description_en','p.name'));

//              $query = EventModel::find(1)->with('comments','author','photos','subscribers','followers','favorites')->get();
////            $query = Category::bySlug('Kristofer Hyatt')->first();
//            return View::make('test')->with(['query'=> $query]);

//            Mail::later('180','test',array(),function($m){
//               $m->to('z4ls@live.com')->from('zals@kaizen.com')->subject('hello zal 123 at 7:10');
//            });
//            return 'Queued';
//            dd(Session::get('url.intended'));
        });



//        Route::get('/artisan',function() {
//           Artisan::call('queue:listen');
//        });

        Route::get('/', array('as'=>'home', 'uses' => 'EventsController@slider'));

        Route::resource('countries', 'CountriesController');
        Route::get('country', array('as' => 'countries','uses' => 'CountriesController@index'));
        Route::get('country/create', array('as' => 'countries/create','uses' => 'CountriesController@create'));
        Route::post('country/create', array('as' => 'createCountry', 'uses' => 'CountriesController@store'));
        Route::get('country/{id}/events', array('uses' => 'CountriesController@getEvents'));

        //Event Routes
        Route::resource('event','EventsController', array('only' => array('index', 'show')));

        //get all events to the main page (8 per page)
        Route::get('events', 'EventsController@index');

        //get events by category name
        Route::get('event/{id}/category', 'EventsController@getCategory');

        //get events by author name
        Route::get('event/{id}/author', 'EventsController@getAuthor');

        //Routes For Event Subscribe, Follow, Favorite .. Route Returns Json Object
        Route::get('event/{id}/subscribe',array('as'=>'event.subscribe','uses'=>'EventsController@subscribe'));
        Route::get('event/{id}/unsubscribe',array('as'=>'event.unsubscribe','uses'=>'EventsController@unsubscribe'));
        Route::get('event/{id}/follow',array('as'=>'event.follow','uses'=>'EventsController@follow'));
        Route::get('event/{id}/unfollow',array('as'=>'event.unfollow','uses'=>'EventsController@unfollow'));
        Route::get('event/{id}/favorite',array('as'=>'event.favorite','uses'=>'EventsController@favorite'));
        Route::get('event/{id}/unfavorite',array('as'=>'event.unfavorite','uses'=>'EventsController@unfavorite'));
        Route::get('events/featured',array('as'=>'event.featured','uses'=>'EventsController@getSliderEvents'));
        Route::get('event/{id}/country','EventsController@getCountry');
        Route::get('event/{id}/location','AdminEventsController@getLocation');

        // Search Route
        Route::get('events/search',array('as'=>'event.search','uses'=>'EventsController@search'));

        //get latest 3 posts for sidebar
        Route::get('events/latest',array('as'=>'event.latest','uses'=>'EventsController@latest'));

        //Category Routes
        Route::resource('categories', 'CategoriesController');
        Route::resource('category','CategoriesController');
        Route::get('category/{id}/events',['as'=>'CategoryEvents','uses'=>'CategoriesController@getEvents']);
        Route::get('category/{id}/posts',['as'=>'CategoryPosts','uses'=>'CategoriesController@getPosts']);

        //Location Routes
        Route::resource('location','LocationsController');
        Route::get('location/{id}/events', ['as'=>'LocationEvents','uses'=>'LocationsController@getEvents']);

        // Contact Us Page
        Route::resource('contact-us','ContactsController', array('only' => array('index','store')));

        # Posts - Second to last set, match slug
        Route::get('blog/{postSlug}', 'BlogController@getView');
        Route::post('blog/{postSlug}', 'BlogController@postView');
        Route::get('blog', array('as' => 'blog','uses' => 'BlogController@getIndex'));
        Route::get('blog/latest',array('as'=>'blog.latest','uses'=>'EventsController@latest'));

        // Post Comment
        Route::resource('event.comments', 'CommentsController', array('only' => array('store')));


        // User reset routes
        Route::get('user/reset/{token}', 'UserController@getReset');

        // User password reset
        Route::post('user/reset/{token}', 'UserController@postReset');

        //:: User Account Routes ::
        Route::post('user/{user}/edit', 'UserController@postEdit');

        //:: User Account Routes ::
        Route::get('user/login', array('as' => 'user.getLogin', 'uses' => 'UserController@getLogin'));

        Route::post('user/login', array('as' => 'login', 'uses' => 'UserController@postLogin'));

        Route::get('user/logout', array('as' => 'logout', 'uses' => 'UserController@getLogout'));

        //profie
        Route::get('user/{user}/profile', array('as' => 'profile', 'uses' => 'UserController@getProfile'));


        # User RESTful Routes (Login, Logout, Register, etc)
        Route::get('user/register', array('as'=>'register','uses'=>'UserController@create'));
        Route::post('user/register', array('uses'=>'UserController@store'));

        Route::get('user/forgot', array('as'=>'forgot','uses'=>'UserController@getForgot'));
        Route::post('user/forgot', array('as'=>'forgot','uses'=>'UserController@postForgot'));

        Route::resource('user', 'UserController');

        // Newsletter Route
        // Route::post('newsletter/subscribe', array('as'=>'newsletter','uses'=>'NewslettersController@store'));
        Route::get('newsletter/subscribe', function() {
            return View::make('test');
        });
        Route::post('newsletter','NewslettersController@store');

        // Just  a Test Route
        Route::get('/mailchimp', function() {
            $user = User::find(2);
            $email = array();
            $email['email']= $user->email;
            Notify::userSubscriber($email);
            dd($user->toArray());
        });


        /* Admin Route Group */
        Route::group(array('prefix' => 'admin', 'before' =>'auth|Moderator'), function () {

            // Just a Test Route to find the Roles of a User
            Route::get('/findRoles/{role}',function($role) {
                $user = new User();
                $users = $user->getRoleByName($role);
                foreach ($users as $user) {
                    echo $user->username.'<br>';
                }
            });

            # Comment Management
            Route::get('comments/{comment}/edit', 'AdminCommentsController@getEdit');
            Route::post('comments/{comment}/edit', 'AdminCommentsController@postEdit');
            Route::get('comments/{comment}/delete', 'AdminCommentsController@getDelete');
            Route::post('comments/{comment}/delete', 'AdminCommentsController@postDelete');
            Route::controller('comments', 'AdminCommentsController');

            # Blog Management
            Route::get('blogs/{post}/show', 'AdminBlogsController@getShow');
            Route::get('blogs/{post}/edit', 'AdminBlogsController@getEdit');
            Route::post('blogs/{post}/edit', 'AdminBlogsController@postEdit');
            Route::get('blogs/{post}/delete', 'AdminBlogsController@getDelete');
            Route::post('blogs/{post}/delete', 'AdminBlogsController@postDelete');
            Route::controller('blogs', 'AdminBlogsController');

            # User Management
            Route::get('users/{user}/show', array('uses'=>'AdminUsersController@getShow'));
            Route::get('users/{user}/edit', 'AdminUsersController@getEdit');
            Route::post('users/{user}/edit', 'AdminUsersController@postEdit');
            Route::get('users/{user}/delete', 'AdminUsersController@getDelete');
            Route::post('users/{user}/delete', 'AdminUsersController@postDelete');
            Route::controller('users', 'AdminUsersController');

            # User Role Management
            Route::get('roles/{role}/show', 'AdminRolesController@getShow');
            Route::get('roles/{role}/edit', 'AdminRolesController@getEdit');
            Route::post('roles/{role}/edit', 'AdminRolesController@postEdit');
            Route::get('roles/{role}/delete', 'AdminRolesController@getDelete');
            Route::post('roles/{role}/delete', 'AdminRolesController@postDelete');
            Route::controller('roles', 'AdminRolesController');

            // Admin Event Route
            Route::resource('event','AdminEventsController');
            Route::get('events','AdminEventsController@index');
            Route::get('event/{id}/followers','AdminEventsController@getFollowers');
            Route::get('event/{id}/favorites','AdminEventsController@getFavorites');
            Route::get('event/{id}/subscriptions','AdminEventsController@getSubscriptions');
            Route::get('event/{id}/country','AdminEventsController@getCountry');
            Route::get('event/{id}/location','AdminEventsController@getLocation');
            Route::get('event/{id}/notifyFollowers', 'AdminEventsController@notifyFollowers');
            # Admin Dashboard
            Route::controller('/', 'AdminDashboardController');

            //            Auth::loginUsingId(2);
            //            $user = Auth::user();
            //            if ($user->hasRole('moderator') )
            //            {
            //                dd('admin');
            //            }
        });

    }

);
