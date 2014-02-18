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
        'prefix' => LaravelLocalization::setLocale(),
        'before' => 'LaravelLocalizationRedirectFilter' // LaravelLocalization filter
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

//              $query = EventModel::find(1)->with('comments','author','photos','subscribers','followers','favorites')->get();
////            $query = Category::bySlug('Kristofer Hyatt')->first();
//            return View::make('test')->with(['query'=> $query]);

        });

        Route::get('/', array('as'=>'home', 'uses' => 'EventsController@index'));

        Route::resource('countries', 'CountriesController');
        Route::get('country', array('as' => 'countries','uses' => 'CountriesController@index'));
        Route::get('country/create', array('as' => 'countries/create','uses' => 'CountriesController@create'));
        Route::post('country/create', array('as' => 'createCountry', 'uses' => 'CountriesController@store'));

        //Event Routes
        Route::resource('event','EventsController');
        //get all events
        Route::get('events', 'EventsController@index');

        //get events by category name
        Route::get('event/{id}/category', 'EventsController@getCategory');

        //get events by author name
        Route::get('event/{id}/author', 'EventsController@getAuthor');

        //get event followers
        Route::get('event/{id}/followers','EventsController@getFollowers');
        Route::get('event/{id}/favorites','EventsController@getFavorites');
        Route::get('event/{id}/subscriptions','EventsController@getSubscriptions');
        Route::get('event/{id}/country','EventsController@getCountry');
        Route::get('event/{id}/location','EventsController@getLocation');
        Route::get('event/{id}/notifyFollowers', 'EventsController@notifyFollowers');
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


        //followers

        // Admin Route Group
        Route::group(array('prefix' => 'admin', 'before' => 'auth'), function () {

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
            Route::get('users/{user}/show', 'AdminUsersController@getShow');
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
        Route::controller('user', 'UserController');



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
