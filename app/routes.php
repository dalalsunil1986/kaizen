<?php

Route::pattern('id', '[0-9]+');

Route::pattern('token', '[0-9a-z]+');

/*********************************************************************************************************
 * Event Routes
 ********************************************************************************************************/
Route::get('event/{id}/online', 'EventsController@streamEvent');

Route::get('event/{id}/offline', 'EventsController@streamEventOld');

Route::get('event/{id}/category', 'EventsController@getCategory');

Route::get('event/{id}/author', 'EventsController@getAuthor');

Route::get('event/{id}/follow', array('as' => 'event.follow', 'uses' => 'EventsController@follow'));

Route::get('event/{id}/unfollow', array('as' => 'event.unfollow', 'uses' => 'EventsController@unfollow'));

Route::get('event/{id}/favorite', array('as' => 'event.favorite', 'uses' => 'EventsController@favorite'));

Route::get('event/{id}/unfavorite', array('as' => 'event.unfavorite', 'uses' => 'EventsController@unfavorite'));

Route::get('events/featured', array('as' => 'event.featured', 'uses' => 'EventsController@getSliderEvents'));

Route::get('event/{id}/country', 'EventsController@getCountry');

Route::get('event/{id}/options', 'EventsController@showSubscriptionOptions');

Route::get('event/{id}/suggest', 'EventsController@getSuggestedEvents');

Route::post('event/{id}/organize', 'EventsController@reorganizeEvents');

Route::get('event/{id}/organize', 'EventsController@reorganizeEvents');

Route::resource('event.comments', 'CommentsController', array('only' => array('store')));

Route::get('online-event', 'EventsController@onlineTestEvent');

Route::resource('event', 'EventsController', array('only' => array('index', 'show')));

/*********************************************************************************************************
 * Subscription Route
 ********************************************************************************************************/
Route::get('package', 'SubscriptionsController@subscribePackage');

Route::post('subscribe', 'SubscriptionsController@subscribe');

Route::get('subscribe', 'SubscriptionsController@subscribe');

Route::get('event/{id}/confirm', 'SubscriptionsController@confirmSubscription');

Route::get('event/{id}/unsubscribe', 'SubscriptionsController@unsubscribe');

/*********************************************************************************************************
 * Payment
 ********************************************************************************************************/
Route::get('event/{id}/payment/options', 'PaymentsController@getPayment');

Route::post('payment', 'PaymentsController@postPayment');

Route::get('payment/final', 'PaymentsController@getFinal');

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

/*********************************************************************************************************
 * Tags
 ********************************************************************************************************/
Route::get('tag/{id}/event', 'TagsController@getEvents' );

Route::get('tag/{id}/blog', 'TagsController@getBlogs' );

Route::resource('tag', 'TagsController', array('only' => array('show')));

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

Route::post('password/reset', ['as' => 'user.token.post', 'uses' => 'AuthController@postReset']);

Route::get('account/activate/{token}', ['as' => 'user.token.confirm', 'uses' => 'AuthController@activate']);

Route::post('account/send-activation-link', ['as' => 'user.token.send-activation', 'uses' => 'AuthController@sendActivationLink']);


/*********************************************************************************************************
 * User Routes
 ********************************************************************************************************/
Route::get('user/{id}/profile', array('as' => 'profile', 'uses' => 'UserController@getProfile'));

Route::resource('user', 'UserController');

/*********************************************************************************************************
 * Category Routes
 ********************************************************************************************************/
Route::get('category/{id}/event', array('as' => 'CategoryEvents', 'uses' => 'CategoriesController@getEvents'));

Route::get('category/{id}/blog', array('as' => 'CategoryPosts', 'uses' => 'CategoriesController@getPosts'));

/*********************************************************************************************************
 * Newsletter Routes
 ********************************************************************************************************/
Route::post('newsletter/subscribe', 'NewslettersController@subscribe');

//Route::get('newsletter', 'NewslettersController@index');

/*********************************************************************************************************
 * MISC ROUTES
 ********************************************************************************************************/
Route::get('forbidden', function () {
    return View::make('error.forbidden');
});

Route::get('country/{country}', 'LocaleController@setCountry');

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));

/*********************************************************************************************************
 * Admin Routes
 ********************************************************************************************************/
Route::group(array('prefix' => 'admin', 'before' => array('Auth', 'Moderator')), function () {

    /*********************************************************************************************************
     * Admin Comments Routes
     ********************************************************************************************************/
    Route::resource('comments', 'AdminCommentsController');

    /*********************************************************************************************************
     * Admin Blog Management Routes
     ********************************************************************************************************/
    Route::get('blogs/{id}/delete', 'AdminBlogsController@getDelete');

    Route::get('blogs/data', 'AdminBlogsController@getData');

    Route::resource('blogs', 'AdminBlogsController');

    /*********************************************************************************************************
     * User Management Routes
     ********************************************************************************************************/
    Route::get('users/{user}/show', array('uses' => 'AdminUsersController@getShow'));

    Route::get('users/{user}/delete', 'AdminUsersController@getDelete');

    Route::post('users/{user}/delete', 'AdminUsersController@postDelete');

    Route::get('users/{id}/report', 'AdminUsersController@getReport');

    Route::post('users/{id}/report', 'AdminUsersController@postReport');

    Route::get('users/{id}/print', 'AdminUsersController@printDetail');

    Route::resource('users', 'AdminUsersController');

    /*********************************************************************************************************
     * Admin User Role Management Routes
     ********************************************************************************************************/
    Route::resource('roles', 'AdminRolesController');

    /*********************************************************************************************************
     * Admin Events Routes
     ********************************************************************************************************/
    Route::get('event/{id}/followers', 'AdminEventsController@getFollowers');

    Route::get('event/{id}/favorites', 'AdminEventsController@getFavorites');

    Route::get('event/{id}/subscriptions', 'AdminEventsController@getSubscriptions');

    Route::get('event/{id}/country', 'AdminEventsController@getCountry');

    Route::get('event/{id}/location', 'AdminEventsController@getLocation');

    Route::get('event/{id}/mail-followers', 'AdminEventsController@getMailFollowers');

    Route::post('event/{id}/mail-followers', 'AdminEventsController@postMailFollowers');

    Route::get('event/{id}/mail-subscribers', 'AdminEventsController@getMailSubscribers');

    Route::post('event/{id}/mail-subscribers', 'AdminEventsController@postMailSubscribers');

    Route::get('event/{id}/mail-favorites', 'AdminEventsController@getMailFavorites');

    Route::post('event/{id}/mail-favorites', 'AdminEventsController@postMailFavorites');

    Route::get('event/{id}/location', 'AdminEventsController@getLocation');

    Route::get('event/{id}/settings', 'AdminEventsController@getSettings');

    Route::get('event/{id}/details', 'AdminEventsController@getDetails');

    Route::get('event/{id}/requests', array('uses' => 'AdminEventsController@getRequests'));

    Route::get('event/type/create', 'AdminEventsController@selectType');

    Route::resource('event', 'AdminEventsController');

    /*********************************************************************************************************
     * Package routes
     ********************************************************************************************************/
    Route::get('package/{id}/settings', 'AdminPackagesController@settings');

    Route::resource('package', 'AdminPackagesController');

    /*********************************************************************************************************
     * Event Settings Routes
     ********************************************************************************************************/
    Route::get('setting/{id}/add-online-room', 'AdminSettingsController@getAddRoom');

    Route::post('setting/{id}/add-online-room', 'AdminSettingsController@postAddRoom');

    Route::resource('settings', 'AdminSettingsController');

    /*********************************************************************************************************
     * Category Routes
     ********************************************************************************************************/
    Route::resource('category', 'AdminCategoriesController');

    /*********************************************************************************************************
     * Country Routes
     ********************************************************************************************************/
    Route::resource('country', 'AdminCountriesController');

    /*********************************************************************************************************
     * Location Routes
     ********************************************************************************************************/
    Route::get('location/{id}/events', array('as' => 'LocationEvents', 'uses' => 'AdminLocationsController@getEvents'));

    Route::resource('locations', 'AdminLocationsController');

    /*********************************************************************************************************
     * Tag Routes
     ********************************************************************************************************/
    Route::resource('tags', 'AdminTagsController');

    /*********************************************************************************************************
     * Ads Route
     ********************************************************************************************************/
    Route::post('ads/{id}/update-active', 'AdminAdsController@updateActive');

    Route::resource('ads', 'AdminAdsController');

    /*********************************************************************************************************
     * Contact US Routes
     ********************************************************************************************************/
    Route::resource('contact-us', 'AdminContactsController', array('only' => array('index', 'store')));

    /*********************************************************************************************************
     * Photo Routes
     ********************************************************************************************************/
    Route::get('photo-normal', 'AdminPhotosController@createNormal');

    Route::resource('photo', 'AdminPhotosController');

    /*********************************************************************************************************
     * Event Requests Route
     ********************************************************************************************************/
    Route::resource('subscription', 'AdminSubscriptionsController');

    /*********************************************************************************************************
     * Payment Routes
     ********************************************************************************************************/
    Route::resource('payment', 'AdminPaymentsController');

    /*********************************************************************************************************
     * Refunds
     ********************************************************************************************************/
    Route::resource('refund', 'AdminRefundsController');

    /*********************************************************************************************************
     * Event Type Routes
     ********************************************************************************************************/
    Route::resource('type', 'AdminTypesController');

    /*********************************************************************************************************
     * Admin Dashboard
     ********************************************************************************************************/
    Route::get('/', 'AdminEventsController@index');

});

/*********************************************************************************************************
 * Iron Queue Workers
 ********************************************************************************************************/
Route::post('queue/iron', function () {
    return Queue::marshal();
});

/*********************************************************************************************************
 * Test Routes
 ********************************************************************************************************/
Route::get('test', function () {

    $susbcription = new Subscription();
    $users_email = [
        'mooon_83@hotmail.com',' Rialenazi@ud.ed.sa',' alammora@gmail.com',' Tolen2013@gmail.com',' joy_of_time@hotmail.com',' nw_5@hotmail.com',' Teacher_safeya@hotmail.com',' altoot911@gmail.com',' Be.lucky2013@yahoo.com',' o.l.a.68@hotmail.com',' fatimafatima7676@gmail.com',' azorrah@gmail.com',' haifa_alkhenaifer@hotmail.com',' Meesho0o990@hotmail.com',' Love.noura.qtr@gmail.com',' Huda.almuraikhi@hotmail.com',' Amina.ali@msn.com',' Qmra22.33@gmail.com',' Deema@tijan.net',' saadhannoudi@gmail.com',' Amhz2468@gmail.com',' Yousif-almanea@hotmail.com',' Nndd061970@yahoo.fr',' Hnooon666@hotmail.com',' Auosh111@hotmail.com',' dr_nada@hotmail.com.co.uk',' Naft432@hotmail.com',' nabet@hotmail.com',' jaldawoud@gmail.com',' Nahla123@hotmail.com',' huda1155@hotmail.com',' Shamayel@platinum-book.com',' aishamasre@hotmail.com',' nadiamasre@hotmail.com',' Baheya2@hotmail.com',' Khalsa.hadidi@omantel.com',' F_baraja@hotmail.com',' Na_aoo@hotmail.com',' Zainb_n89@yahoo.com',' yasmeena@live.com',' falkonreem@yahoo.com',' abeerfm@yahoo.com',' Bentalqaser@hotmail.com',' Mfud-1407@hotmail.com',' Maryam.a.hussain@gmail.com',' Choco.berry.5@hotmail.com',' Jumanah.khayat@gmail.com',' Nouf.ma.Saud@gmail.com',' D.bandar@hotmail.com',' s.bandar@hotmail.com',' Naalsammak@hotmail.com',' B7r_al_3yoon@hotmail.com',' abeer@sec.gov.qa',' quseear@gmail.com',' aysha.alnajjar@gmail.com',' S.a.alrashed@gmail.com',' Hessa.f.s@gmail.com',' tmohamad15@gmail.com',' zad310@gmail.com',' badria.shihi@omantel.om',' ta6m1990@hotmail.com',' massa248@hotmail.com',' shuaa_81@hotmail.com',' bisaan408@gmail.com',' engineerz82@yahoo.com',' fatmahhaider@gmail.com',' falaj1978@gmail.com',' laalalmai@gmail.com',' Ash.saeed.84@gmail.com',' norahaa9@gmail.com',' ljmj1999@hotmail.com',' Eng_nouf.a.s@hotmail.com',' loleetana@gmail.com',' nahar430@hotmail.com',' amal.almana@hotmail.com',' amal.almana@hotmail.com',' shekah.d@gmail.com',' q8ya89@outlook.com',' noufjw@gmail.com'
    ];

    foreach($users_email as $email) {
        $user = User::firstByAttributes('email',$email);
        dd($user);
    }

});