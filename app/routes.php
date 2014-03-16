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
        });



//        Route::get('/artisan',function() {
//           Artisan::call('queue:listen');
//        });

        Route::get('/', array('as'=>'home', 'uses' => 'EventsController@slider'));

        Route::resource('countries', 'CountriesController');
        Route::get('country', array('as' => 'countries','uses' => 'CountriesController@index'));
        Route::get('country/create', array('as' => 'countries/create','uses' => 'CountriesController@create'));
        Route::post('country/create', array('as' => 'createCountry', 'uses' => 'CountriesController@store'));

        //Event Routes
        Route::resource('event','EventsController', array('only' => array('index', 'show')));

        //get all events to the main page (8 per page)
        Route::get('events', 'EventsController@index');

        //get events by category name
        Route::get('event/{id}/category', 'EventsController@getCategory');

        //get events by author name
        Route::get('event/{id}/author', 'EventsController@getAuthor');

        //get event followers
        Route::get('event/{id}/subscribe','EventsController@subscribe');
        Route::get('event/{id}/unsubscribe','EventsController@unsubscribe');
        Route::get('event/{id}/follow','EventsController@follow');
        Route::get('event/{id}/unfollow','EventsController@unfollow');
        Route::get('event/{id}/favorite','EventsController@favorite');
        Route::get('event/{id}/unfavorite','EventsController@unfavorite');

        Route::get('events/featured','EventsController@getSliderEvents');
        Route::get('events/search','EventsController@search');

        //Category Routes
        Route::resource('categories', 'CategoriesController');
        Route::resource('category','CategoriesController');
        Route::get('category/{id}/events',['as'=>'CategoryEvents','uses'=>'CategoriesController@getEvents']);
        Route::get('category/{id}/posts',['as'=>'CategoryPosts','uses'=>'CategoriesController@getPosts']);

        Route::resource('locations', 'LocationsController');
        //Location Routes
        Route::resource('location','LocationsController');
        Route::get('location/{id}/events', ['as'=>'LocationEvents','uses'=>'LocationsController@getEvents']);
        // Posts Routes

        // Contact Us Page
        Route::resource('contact-us','ContactsController');


        # Posts - Second to last set, match slug
        Route::get('blog/{postSlug}', 'BlogController@getView');
        Route::post('blog/{postSlug}', 'BlogController@postView');
        Route::get('blog', array('as' => 'blog','uses' => 'BlogController@getIndex'));


        //followers

        // Admin Route Group
        Route::group(array('prefix' => 'admin', 'before' =>'auth|Moderator'), function () {


            Route::get('/findRoles/{role}',function($role) {
                $user = new User();
                $users = $user->getRoleByName($role);
//                dd($users->toArray());
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

//            Auth::loginUsingId(2);
//            $user = Auth::user();
//
////            dd($user);
//
//            if ($user->hasRole('moderator') )
//            {
////                dd('moderator');
//                dd('admin');
//            }
            #event

            Route::resource('event','AdminEventsController');
            Route::get('event/{id}/followers','AdminEventsController@getFollowers');
            Route::get('event/{id}/favorites','AdminEventsController@getFavorites');
            Route::get('event/{id}/subscriptions','AdminEventsController@getSubscriptions');
            Route::get('event/{id}/country','AdminEventsController@getCountry');
            Route::get('event/{id}/location','AdminEventsController@getLocation');
            Route::get('event/{id}/notifyFollowers', 'AdminEventsController@notifyFollowers');

            # Admin Dashboard
            Route::controller('/', 'AdminDashboardController');


        });

        /** ------------------------------------------
         *  Frontend Routes
         *  ------------------------------------------
         */

        // User reset routes
        Route::get('user/reset/{token}', 'UserController@getReset');
        // User password reset
        Route::post('user/reset/{token}', 'UserController@postReset');
        //:: User Account Routes ::
        Route::post('user/{user}/edit', 'UserController@postEdit');

        //:: User Account Routes ::
        Route::post('user/login', array('as' => 'login', 'uses' => 'UserController@postLogin'));

        # User RESTful Routes (Login, Logout, Register, etc)
        Route::get('user/register', array('as'=>'register','uses'=>'UserController@create'));
        Route::post('user/register', array('uses'=>'UserController@store'));



        Route::controller('user', 'UserController');

//        Route::post('newsletter/subscribe', array('as'=>'newsletter','uses'=>'NewslettersController@store'));
        Route::get('newsletter/subscribe', function() {
            return View::make('test');
        });


        Route::get('/mailchimp', function() {
            $user = User::find(2);
            $email = array();
            $email['email']= $user->email;
            Notify::userSubscriber($email);
            dd($user->toArray());
        });

        // newsletter subscribe route
        Route::post('newsletter','NewslettersController@storeNewsletter');


//        /** ------------------------------------------
//         *  Frontend Routes
//         *  ------------------------------------------
//         */
//
//        // User reset routes
//        Route::get('user/reset/{token}', 'UserController@getReset');
//        // User password reset
//        Route::post('user/reset/{token}', 'UserController@postReset');
//        //:: User Account Routes ::
//        Route::post('user/{user}/edit', 'UserController@postEdit');
//
//        //:: User Account Routes ::
//        Route::post('user/login', 'UserController@postLogin');
//
//        # User RESTful Routes (Login, Logout, Register, etc)
//        Route::controller('user', 'AdminUsersController');
    }

);
