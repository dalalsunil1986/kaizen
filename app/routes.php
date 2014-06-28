<?php
/*********************************************************************************************************
 * Route Model Bindings
 ********************************************************************************************************/
Route::model('comment', 'Comment');

Route::model('role', 'Role');

/** ------------------------------------------
 *  Route constraint patterns
 *  ------------------------------------------ */
Route::pattern('comment', '[0-9]+');

Route::pattern('user', '[0-9]+');

Route::pattern('id', '[0-9]+');

Route::pattern('role', '[0-9]+');

Route::pattern('token', '[0-9a-z]+');

/*********************************************************************************************************
 * Event Routes
 ********************************************************************************************************/
Route::get('event/{id}/category', 'EventsController@getCategory');

Route::get('event/{id}/author', 'EventsController@getAuthor');

Route::get('event/{id}/subscribe', array('as' => 'event.subscribe', 'uses' => 'SubscriptionsController@subscribe'));

Route::get('event/{id}/unsubscribe', array('as' => 'event.unsubscribe', 'uses' => 'EventsController@unsubscribe'));

Route::get('event/{id}/follow', array('as' => 'event.follow', 'uses' => 'EventsController@follow'));

Route::get('event/{id}/unfollow', array('as' => 'event.unfollow', 'uses' => 'EventsController@unfollow'));

Route::get('event/{id}/favorite', array('as' => 'event.favorite', 'uses' => 'EventsController@favorite'));

Route::get('event/{id}/unfavorite', array('as' => 'event.unfavorite', 'uses' => 'EventsController@unfavorite'));

Route::get('events/featured', array('as' => 'event.featured', 'uses' => 'EventsController@getSliderEvents'));

Route::get('event/{id}/country', 'EventsController@getCountry');

Route::resource('event.comments', 'CommentsController', array('only' => array('store')));

Route::resource('event', 'EventsController', array('only' => array('index', 'show')));

/*********************************************************************************************************
 * Contact Us Route
 ********************************************************************************************************/

Route::resource('contact', 'ContactsController', array('only' => array('index')));

Route::post('contact/contact', 'ContactsController@contact');

/*********************************************************************************************************
 * Posts
 ********************************************************************************************************/

Route::get('consultancy', array('as' => 'consultancy', 'uses' => 'BlogsController@consultancy'));

Route::resource('blog', 'BlogsController', array('only' => array('index', 'show', 'view')));

// Post Comment

/*********************************************************************************************************
 * Auth Routes
 ********************************************************************************************************/
Route::get('account/login', ['as' => 'user.login.get', 'uses' => 'AuthController@getLogin']);

Route::post('account/login', ['as' => 'user.login.post', 'uses' => 'AuthController@postLogin']);

Route::get('account/logout', ['as' => 'user.logout', 'uses' => 'AuthController@getLogout']);

Route::get('account/signup', ['as' => 'user.register.get', 'uses' => 'AuthController@getSignup']);

Route::post('account/signup', ['as' => 'user.register.post', 'uses' => 'AuthController@postSignup']);

Route::get('account/forgot', ['as' => 'user.forgot.get', 'uses' => 'AuthController@getForgot']);

Route::post('account/forgot', ['as' => 'user.forgot.post', 'uses' => 'AuthController@postForgot']);

Route::get('password/reset/{token}', ['as' => 'user.token.get', 'uses' => 'AuthController@getReset']);

Route::post('password/reset/{token}', ['as' => 'user.token.post', 'uses' => 'AuthController@postReset']);

Route::get('account/activate/{token}', ['as' => 'user.token.confirm', 'uses' => 'AuthController@activate']);


/*********************************************************************************************************
 * User Routes
 ********************************************************************************************************/

Route::get('user/{id}/profile',  array('as' => 'profile', 'uses' => 'UserController@getProfile'));

Route::resource('user', 'UserController');

/*********************************************************************************************************
 * Category Routes
 ********************************************************************************************************/
Route::get('category/{id}/events', array('as' => 'CategoryEvents', 'uses' => 'CategoriesController@getEvents'));

Route::get('category/{id}/posts', array('as' => 'CategoryPosts', 'uses' => 'CategoriesController@getPosts'));

/*********************************************************************************************************
 * Country Routes
 ********************************************************************************************************/
Route::get('country/{id}/events', array('uses' => 'CountriesController@getEvents'));

/*********************************************************************************************************
 * Newsletter Routes
 ********************************************************************************************************/
Route::post('newsletter', 'NewslettersController@store');

/*********************************************************************************************************
 * MISC ROUTES
 ********************************************************************************************************/
Route::get('forbidden', function () {
    return View::make('error.forbidden');
});

//push queue worker
Route::post('queue/mails', function () {
    return Queue::marshal();
});

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));

/*********************************************************************************************************
 * Admin Routes
 ********************************************************************************************************/
Route::group(array('prefix' => 'admin', 'before' => array('Auth', 'Moderator')), function () {
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
    Route::get('users/{user}/show', array('uses' => 'AdminUsersController@getShow'));
    Route::get('users/{user}/edit', 'AdminUsersController@getEdit');
    Route::post('users/{user}/edit', 'AdminUsersController@postEdit');
    Route::get('users/{user}/delete', 'AdminUsersController@getDelete');
    Route::post('users/{user}/delete', 'AdminUsersController@postDelete');
    Route::get('users/{id}/report', 'AdminUsersController@getReport');
    Route::post('users/{id}/report', 'AdminUsersController@postReport');
    Route::controller('users', 'AdminUsersController');

    # User Role Management
    Route::get('roles/{role}/show', 'AdminRolesController@getShow');
    Route::get('roles/{role}/edit', 'AdminRolesController@getEdit');
    Route::post('roles/{role}/edit', 'AdminRolesController@postEdit');
    Route::get('roles/{role}/delete', 'AdminRolesController@getDelete');
    Route::post('roles/{role}/delete', 'AdminRolesController@postDelete');
    Route::controller('roles', 'AdminRolesController');

    // Admin Event Route
    Route::get('event/{id}/followers', 'AdminEventsController@getFollowers');
    Route::get('event/{id}/favorites', 'AdminEventsController@getFavorites');
    Route::get('event/{id}/subscriptions', 'AdminEventsController@getSubscriptions');
    Route::get('event/{id}/country', 'AdminEventsController@getCountry');
    Route::get('event/{id}/location', 'AdminEventsController@getLocation');
    Route::post('event/{id}/mailFollowers', 'AdminEventsController@mailFollowers');
    Route::post('event/{id}/mailSubscribers', 'AdminEventsController@mailSubscribers');
    Route::post('event/{id}/mailFavorites', 'AdminEventsController@mailFavorites');
    Route::get('event/{id}/location', 'AdminEventsController@getLocation');
    Route::get('event/{id}/settings', 'AdminEventsController@settings');
    Route::resource('event', 'AdminEventsController');

    //category
    Route::resource('category', 'AdminCategoriesController');

    //countries
    Route::resource('country', 'AdminCountriesController');

    //Location Routes
    Route::get('location/{id}/events', array('as' => 'LocationEvents', 'uses' => 'AdminLocationsController@getEvents'));
    Route::resource('locations', 'AdminLocationsController');

    //ads
    Route::resource('ads', 'AdminAdsController', array('only' => array('index', 'store')));

    //contact-us
    Route::resource('contact-us', 'AdminContactsController', array('only' => array('index', 'store')));

    Route::resource('photo', 'AdminPhotosController');
    Route::resource('requests', 'AdminStatusesController');
    Route::resource('type', 'AdminTypesController');

    Route::get('event/{id}/requests', array('uses' => 'AdminEventsController@getRequests'));
    Route::resource('requests', 'AdminStatusesController');

    Route::get('/', 'AdminEventsController@index');
});