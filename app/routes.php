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
Route::model('comment', 'Comment');
Route::model('post', 'Post');
Route::model('role', 'Role');
Route::model('user', 'User');

Route::group(
    array(
        'prefix' => LaravelLocalization::setLocale(), // default : English === it will set the local language according to the session
        'before' => 'LaravelLocalizationRedirectFilter' // LaravelLocalization filter
    ),
    function()
    {
        //Event Routes
        Route::resource('event','EventsController', array('only' => array('index', 'show')));
        Route::get('events', 'EventsController@index');
        Route::get('event/{id}/category', 'EventsController@getCategory');
        Route::get('event/{id}/author', 'EventsController@getAuthor');
        Route::get('event/{id}/subscribe',array('as'=>'event.subscribe','uses'=>'EventsController@subscribe'));
        Route::get('event/{id}/unsubscribe',array('as'=>'event.unsubscribe','uses'=>'EventsController@unsubscribe'));
        Route::get('event/{id}/follow',array('as'=>'event.follow','uses'=>'EventsController@follow'));
        Route::get('event/{id}/unfollow',array('as'=>'event.unfollow','uses'=>'EventsController@unfollow'));
        Route::get('event/{id}/favorite',array('as'=>'event.favorite','uses'=>'EventsController@favorite'));
        Route::get('event/{id}/unfavorite',array('as'=>'event.unfavorite','uses'=>'EventsController@unfavorite'));
        Route::get('events/featured',array('as'=>'event.featured','uses'=>'EventsController@getSliderEvents'));
        Route::get('event/{id}/country','EventsController@getCountry');


        // Search Route
        Route::get('events/search',array('as'=>'event.search','uses'=>'EventsController@search'));

        //get latest 3 posts for sidebar
        Route::get('events/latest',array('as'=>'event.latest','uses'=>'EventsController@latest'));
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
        Route::get ('user/reset/{token}', 'UserController@getReset');
        Route::post('user/reset/{token}', 'UserController@postReset');
        Route::post('user/{id}/edit', 'UserController@postEdit');
        Route::get ('user/login', array('as' => 'user.getLogin', 'uses' => 'UserController@getLogin'));
        Route::post('user/login', array('as' => 'login', 'uses' => 'UserController@postLogin'));
        Route::get ('user/logout', array('as' => 'logout', 'uses' => 'UserController@getLogout'));
        Route::get ('user/{id}/profile', array('as' => 'profile', 'uses' => 'UserController@getProfile'));
        Route::get ('user/register', array('as'=>'register','uses'=>'UserController@create'));
        Route::post('user/register', array('uses'=>'UserController@store'));
        Route::get ('user/forgot', array('as'=>'forgot','uses'=>'UserController@getForgot'));
        Route::post('user/forgot', array('as'=>'forgot','uses'=>'UserController@postForgot'));
        Route::get('user/{id}/edit', array('uses'=>'UserController@edit'));

        Route::resource('user', 'UserController');

        //Category Routes
        Route::get('category/{id}/events',['as'=>'CategoryEvents','uses'=>'CategoriesController@getEvents']);
        Route::get('category/{id}/posts',['as'=>'CategoryPosts','uses'=>'CategoriesController@getPosts']);

        //country
        Route::get('country/{id}/events', array('uses' => 'CountriesController@getEvents'));

        // Newsletter Route
        Route::post('newsletter','NewslettersController@store');

        Route::get('ads1','AdsController@getAd1');
        Route::get('ads2','AdsController@getAd2');

        Route::get('/', array('as'=>'home', 'uses' => 'EventsController@slider'));

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
            Route::get('events','AdminEventsController@index');
            Route::get('event/{id}/followers','AdminEventsController@getFollowers');
            Route::get('event/{id}/favorites','AdminEventsController@getFavorites');
            Route::get('event/{id}/subscriptions','AdminEventsController@getSubscriptions');
            Route::get('event/{id}/country','AdminEventsController@getCountry');
            Route::get('event/{id}/location','AdminEventsController@getLocation');
            Route::get('event/{id}/notifyFollowers', 'AdminEventsController@notifyFollowers');
            Route::get('event/{id}/location','AdminEventsController@getLocation');
            Route::get('event/{id}/settings','AdminEventsController@settings');
//            Route::get('event/{id}/followers','AdminEventsController@viewFollowers');
//            Route::get('event/{id}/subscribers','AdminEventsController@viewSubscribers');
//            Route::get('event/{id}/favorites','AdminEventsController@viewFavorites');


            Route::resource('event','AdminEventsController');

            //category
            Route::resource('category','AdminCategoriesController');

            //countries

            Route::resource('country', 'AdminCountriesController');
            //Location Routes
            Route::get('location/{id}/events', ['as'=>'LocationEvents','uses'=>'AdminLocationsController@getEvents']);
            Route::resource('locations','AdminLocationsController');

            //ads
            Route::resource('ads','AdminAdsController',array('only' => array('index','store')));

            Route::get('/', 'AdminEventsController@index');



        });

    }

);
