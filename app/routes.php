<?php

/**
 * Route Model Binding
 */
Route::model('comment', 'Comment');
Route::model('role', 'Role');
Route::model('user', 'User');


/** ------------------------------------------
 *  Route constraint patterns
 *  ------------------------------------------
 */
Route::pattern('comment', '[0-9]+');
Route::pattern('user', '[0-9]+');
Route::pattern('id', '[0-9]+');
Route::pattern('role', '[0-9]+');
Route::pattern('token', '[0-9a-z]+');

/**
 * Route Group for Localized url
 */

Route::group(
    array(
        'prefix' => LaravelLocalization::setLocale(), // default : English === it will set the local language according to the session
        'before' => 'LaravelLocalizationRedirectFilter' // LaravelLocalization filter
    ),
    function() {
        //Event Routes
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
        Route::resource('event','EventsController', array('only' => array('index', 'show')));

        // Contact Us Page
        Route::resource('contact-us','ContactsController', array('only' => array('index')));
        Route::post('contact-us/contact','ContactsController@contact');

        # Posts - Second to last set, match slug
        Route::get('consultancy',array('as'=>'consultancy','uses'=>'BlogsController@consultancy'));
        Route::resource('blog','BlogsController', array('only' => array('index', 'show','view')));

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
        Route::get('user/confirm/{token}', array('uses'=>'UserController@confirm'));
        Route::resource('user', 'UserController');

        //Category Routes
        Route::get('category/{id}/events',array('as'=>'CategoryEvents','uses'=>'CategoriesController@getEvents'));
        Route::get('category/{id}/posts',array('as'=>'CategoryPosts','uses'=>'CategoriesController@getPosts'));

        //country
        Route::get('country/{id}/events', array('uses' => 'CountriesController@getEvents'));

        // Newsletter Route
        Route::post('newsletter','NewslettersController@store');

        Route::get('/', array('as'=>'home', 'uses' => 'EventsController@dashboard'));
    }
);

///* Admin Route Group */
Route::group(array('prefix' => 'admin','before'=>array('Auth','Moderator')), function() {
    # Comment Management
    Route::get('comments/{comment}/edit', 'AdminCommentsController@getEdit');
    Route::post('comments/{comment}/edit', 'AdminCommentsController@postEdit');
    Route::get('comments/{comment}/delete', 'AdminCommentsController@getDelete');
    Route::post('comments/{comment}/delete', 'AdminCommentsController@postDelete');
    Route::controller('comments', 'AdminCommentsController');

    # Blog Management
    Route::get('blogs/{id}/delete', 'AdminBlogsController@getDelete');
    Route::get('blogs/data', 'AdminBlogsController@getData');
    Route::resource('blogs', 'AdminBlogsController');

    # User Management
    Route::get('users/{user}/show', array('uses'=>'AdminUsersController@getShow'));
    Route::get('users/{user}/edit', 'AdminUsersController@getEdit');
    Route::post('users/{user}/edit', 'AdminUsersController@postEdit');
    Route::get('users/{user}/delete', 'AdminUsersController@getDelete');
    Route::post('users/{user}/delete', 'AdminUsersController@postDelete');
    Route::get('users/{id}/report','AdminUsersController@getReport');
    Route::post('users/{id}/report','AdminUsersController@postReport');
    Route::controller('users', 'AdminUsersController');

    # User Role Management
    Route::get('roles/{role}/show', 'AdminRolesController@getShow');
    Route::get('roles/{role}/edit', 'AdminRolesController@getEdit');
    Route::post('roles/{role}/edit', 'AdminRolesController@postEdit');
    Route::get('roles/{role}/delete', 'AdminRolesController@getDelete');
    Route::post('roles/{role}/delete', 'AdminRolesController@postDelete');
    Route::controller('roles', 'AdminRolesController');

    // Admin Event Route
    Route::get('event/{id}/followers','AdminEventsController@getFollowers');
    Route::get('event/{id}/favorites','AdminEventsController@getFavorites');
    Route::get('event/{id}/subscriptions','AdminEventsController@getSubscriptions');
    Route::get('event/{id}/country','AdminEventsController@getCountry');
    Route::get('event/{id}/location','AdminEventsController@getLocation');
    Route::post('event/{id}/mailFollowers', 'AdminEventsController@mailFollowers');
    Route::post('event/{id}/mailSubscribers', 'AdminEventsController@mailSubscribers');
    Route::post('event/{id}/mailFavorites', 'AdminEventsController@mailFavorites');
    Route::get('event/{id}/location','AdminEventsController@getLocation');
    Route::get('event/{id}/settings','AdminEventsController@settings');
    Route::resource('event','AdminEventsController');

    //category
    Route::resource('category','AdminCategoriesController');

    //countries
    Route::resource('country', 'AdminCountriesController');

    //Location Routes
    Route::get('location/{id}/events', array('as'=>'LocationEvents','uses'=>'AdminLocationsController@getEvents'));
    Route::resource('locations','AdminLocationsController');

    //ads
    Route::resource('ads','AdminAdsController',array('only' => array('index','store')));

    //contact-us
    Route::resource('contact-us','AdminContactsController',array('only'=>array('index','store')));

    Route::get('/', 'AdminEventsController@index');
});

Route::get('forbidden',function() {
   return View::make('forbidden');
});
Route::get('/', array('as'=>'base', 'uses' => 'EventsController@dashboard'));