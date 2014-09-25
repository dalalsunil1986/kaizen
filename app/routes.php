<?php



//Route::model('role', 'Role');

/** ------------------------------------------
 *  Route constraint patterns
 *  ------------------------------------------ */
Route::pattern('id', '[0-9]+');

//Route::pattern('role', '[0-9]+');

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

Route::get('online-event','EventsController@onlineTestEvent');

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


/*********************************************************************************************************
 * User Routes
 ********************************************************************************************************/

Route::get('user/{id}/profile', array('as' => 'profile', 'uses' => 'UserController@getProfile'));

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
Route::post('newsletter/subscribe', 'NewslettersController@subscribe');

//Route::get('newsletter', 'NewslettersController@index');

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

//    Route::get('users/{user}/edit', 'AdminUsersController@getEdit');
//
//    Route::post('users/{user}/edit', 'AdminUsersController@postEdit');

    Route::get('users/{user}/delete', 'AdminUsersController@getDelete');

    Route::post('users/{user}/delete', 'AdminUsersController@postDelete');

    Route::get('users/{id}/report', 'AdminUsersController@getReport');

    Route::post('users/{id}/report', 'AdminUsersController@postReport');

    Route::get('users/{id}/print','AdminUsersController@printDetail');

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

    Route::post('event/{id}/mailFollowers', 'AdminEventsController@mailFollowers');

    Route::post('event/{id}/mailSubscribers', 'AdminEventsController@mailSubscribers');

    Route::post('event/{id}/mailFavorites', 'AdminEventsController@mailFavorites');

    Route::get('event/{id}/location', 'AdminEventsController@getLocation');

    Route::get('event/{id}/settings', 'AdminEventsController@getSettings');

    Route::get('event/{id}/details', 'AdminEventsController@getDetails');


    Route::get('event/type/create', 'AdminEventsController@selectType');

    Route::post('photo/create', 'AdminEventsController@storeImage');

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
     * Ads Route
     ********************************************************************************************************/
    Route::resource('ads', 'AdminAdsController', array('only' => array('index', 'store')));

    /*********************************************************************************************************
     * Contact US Routes
     ********************************************************************************************************/
    Route::resource('contact-us', 'AdminContactsController', array('only' => array('index', 'store')));

    /*********************************************************************************************************
     * Photo Routes
     ********************************************************************************************************/
    Route::resource('photo', 'AdminPhotosController');

    /*********************************************************************************************************
     * Event Requests Route
     ********************************************************************************************************/
    Route::resource('subscription', 'AdminSubscriptionsController');

    Route::get('event/{id}/requests', array('uses' => 'AdminEventsController@getRequests'));

    /*********************************************************************************************************
     * Event Type Routes
     ********************************************************************************************************/
    Route::resource('type', 'AdminTypesController');

    /*********************************************************************************************************
     * Admin Dashboard
     ********************************************************************************************************/
    Route::get('/', 'AdminEventsController@index');

});


Route::get('test',function() {
//    $event = EventModel::find(1);
//    echo "now: ".\Carbon\Carbon::now();
//    echo "<br>start date: " . $event->date_start;
//    echo "<br>end date: " . $event->date_end;
//
//    $eventRepo = App::make('Acme\\EventModel\\EventRepository');
//    echo "<br> ";
//
//
//    if($eventRepo->ongoingEvent($event->date_start,$event->date_end)) {
//        echo 'ongoing event';
//    } elseif($eventRepo->eventStarted($event->date_start)) {
//        if($eventRepo->eventExpired($event->date_end)) {
//            echo 'event started but expired';
//        } else {
//            echo 'event started but not expired'; // unsubscrive
//        }
//    } elseif($eventRepo->eventExpired($event->date_end)) {
//        echo 'event expired';
//    }
//    dd('');
//
//    dd($eventRepo->eventStarted($event->date_start));
//    dd(\Carbon\Carbon::now());


    $arabic =  [
        'contact_us'   => 'اتصل بنا',
        'nav'          => [
            'home'          => 'رئيسية',
            'admin'         => 'ادمن',
            'login'         => 'دخول',
            'logout'        => 'خروج',
            'register'      => 'تسجيل',
            'main'          => 'الصفحة الرئيسية',
            'events'        => 'الدورات التدريبية',
            'consultancies' => 'الإستشارات',
            'posts'         => 'المدونة',
            'contactus'     => 'الإتصال بنا',
            'search'        => 'بحث',
            'username'      => 'اسم الدخول',
            'password'      => 'كلمة المرور',
            'email'         => 'البريد الإلكتروني',
            'package'       => 'المواسم التدريبية'
        ],
        'event'        => [
            'summaryevent'         => 'تفاصيل الموضوع',
            'totalseats'           => 'إجمالي المقاعد',
            'date_start'           => 'تاريخ البدء',
            'time_start'           => 'يبدأ',
            'seatsavail'           => 'المقاعد المتاحة',
            'date_end'             => 'تاريخ الانتهاء',
            'time_end'             => 'ينتهي',
            'favorite'             => 'ستضاف إلى قائمة المفضلة في حسابك',
            'unfavorite'           => 'الغاء',
            'follow'               => 'للحصول على آخر الأخبار',
            'unfollow'             => 'الغاء',
            'subscribe'            => 'لحجز مقعدك',
            'unsubscribe'          => 'الغاء',
            'comment'              => 'تعليقات',
            'addcomment'           => 'إضافه تعليق',
            'category'             => 'التصنيف',
            'title'                => 'الموضوع',
            'events'               => 'الفعاليات',
            'all'                  => 'جميع',
            'choose_country'       => 'اختر الدولة',
            'choose_category'      => 'اختر الفئة',
            'choose_author'        => 'اختر المدرب',
            'price'                => 'السعر',
            'free'                 => 'مجاني',
            'unsubscribe_btn_desc' => 'الغاء الاشتراك',
            'reorganize'           => 'طلب إعاده تنظيم',
            'online'               => 'دخول غرفة الفعالية',
        ],
        'general'      => array(
            'kaizen'               => 'كايزن',
            'email'                => 'البريد الإلكتروني',
            'submit'               => 'إرسال',
            'comment'              => 'التعليق',
            'remember'             => 'تذكرني',
            'latest_events'        => 'أحدث الفعاليات',
            'latest_blog'          => 'آخر المقالات والأخبار',
            'newsletter'           => 'النشرة البريدية',
            'instagram'            => 'انستجرام',
            'twitter'              => 'تويتر',
            'youtube'              => 'يو تيوب',
            'newsletter_subscribe' => 'الاشتراك بالنشرة البريدية',
            'youlog'               => 'انت مسجل لدينا باسم',
            'profile'              => 'معلوماتي',
            'username'             => 'اسم الدخول',
            'fix_error'            => 'يرجى تصحيح الأخطاء وإعاده المحاولة مرة أخرى ..',
            'first_name'           => ' الاسم بالكامل باللغة العربية',
            'last_name'            => 'الاسم بالكامل - باللغة الانجليزية',
            'pass'                 => 'كلمة المرور',
            'mobile'               => 'الهاتف النقال',
            'country_code'         => 'مفتاح الدولة',
            'pass_confirm'         => 'تأكيد كلمة المرور',
            'telelphone'           => 'تلفون',
            'select_country'       => 'الدولة',
            'birth'                => 'تاريخ الميلاد',
            'gender'               => 'النوع',
            'male'                 => 'ذكر',
            'female'               => 'أنثى',
            'more'                 => 'المزيد ..',
            'entry'                => 'الدخول إلى حساب المستخدم',
            'notavail'             => 'لا يوجد',
            'phone'                => 'الهاتف',
            'country'              => 'الدولة',
            'location'             => 'موقع',
            'dob'                  => 'تاريخ الميلاد',
            'admin_panel'          => 'لوحه التحكم للموقع',
            'subscribe_btn_desc'   => '&nbsp;&nbsp;  اشترك &nbsp; &nbsp;',
            'follow_btn_desc'      => 'متابعة الفعالية',
            'fv_btn_desc'          => 'اضف للمفضلة',
            'prev_events'          => 'هل اشتركت في فعاليات كيزين من قبل .. برجاء ذكر الفعاليات ومكان انعقادها .. شكرا',
            'warning_msg'          => 'يرجى العلم بأن البيانات الواردة باستمارة التسجيل سيتم اعتمادها لإصدار الشهادات .. برجاء كتابه البيانات الصحيحة والتأكد منها',
            'settings'             => 'خصائص',
            'address'              => 'عنوان',
            'vip'                  => 'VIP',
            'online'               => 'Online',
            'normal'               => 'Normal',
            'system-error'         => 'System Error',
            'event-expired'        => 'Sorry, This Event is Expired',
            'check-email'          => 'We have sent you an Email with the Details about your Subscription.',
            'cannot-watch'         => 'You Cannot Watch this event now',
            'event-ongoing'        => 'This Event is Ongoing at present',
            'no-stream'            => 'There is no online stream for this event',
            'not-confirmed'        => 'Your Subscription is not confirmed.',
            'not-online'           => 'You are not subscribed to this event as ONLINE',
            'no-results'           => 'لا يوجد نتائج',
            'keyword'              => 'Keyword',
            'favorites'            => 'مفضلات',
            'subscriptions'        => 'حجزات',
            'followings'           => 'متابعات',
        ),
        'subscription' => [
            'subscribed'         => 'You subscribed this event',
            'unsubscribed'       => 'You unsubscribed this event',
            'already_subscribed' => 'You  already :attribute this event',
            'not_authenticated'  => 'Sorry, You must sign in before you perform this action',
            'wrong_access'       => 'Sorry, Wrong Acces',
            'error'              => 'Sorry, Could not Subscribe you',
            'not_subscribed'     => 'Sorry, you have not Subscribed to this event',
            'rejected'           => 'Sorry, You cannot Register this event',
            'requested'          => 'Your Request For Re-organizing the Event has been sent to the Admin.',
            'followed'           => 'You followed this event.',
            'unfollowed'         => 'You unfollowed this event.',
            'favorited'          => 'You favorited this event.',
            'unfavorited'        => 'You unfavorited this event.',
        ],
        'auth'         => [
            'username'              => 'اسم المستخدم',
            'password'              => 'كلمة المرور',
            'password_confirmation' => 'تأكيد كلمة المرور',
            'e_mail'                => 'البريد الإلكتروني',
            'username_e_mail'       => 'اسم المستخدم أو البريد الإلكتروني',
            'signup'                => [
                'title'                 => 'Signup',
                'desc'                  => 'Signup for new account',
                'confirmation_required' => 'Confirmation required',
                'submit'                => 'Create new account',
            ],
            'login'                 => [
                'title'           => 'الدخول',
                'desc'            => 'إدخال بياناتك السرية',
                'forgot_password' => '(نسيت كلمة المرور)',
                'remember'        => 'تذكرني',
                'submit'          => 'دخول',
            ],
            'forgot'                => [
                'title'  => 'Forgot password',
                'submit' => 'Continue',
            ],
            'alerts'                => [
                'account_created'        => 'Your account has been successfully created. Please check your email for the instructions on how to confirm your account.',
                'too_many_attempts'      => 'Too many attempts. Try again in few minutes.',
                'wrong_credentials'      => 'Incorrect username, email or password.',
                'not_confirmed'          => 'Your account may not be confirmed. Check your email for the confirmation link',
                'confirmation'           => 'Your account has been confirmed! You may now login.',
                'wrong_confirmation'     => 'Wrong confirmation code.',
                'password_forgot'        => 'The information regarding password reset was sent to your email.',
                'wrong_password_forgot'  => 'User not found.',
                'password_reset'         => 'Your password has been changed successfully.',
                'wrong_password_reset'   => 'Invalid password. Try again',
                'wrong_token'            => 'The password reset token is not valid.',
                'duplicated_credentials' => 'يرجى المحاولة مرة أخرى .. اسم المستخدم أو البريد الإلكتروني مسجل لدينا من قبل ',
            ],
            'email'                 => [
                'account_confirmation' => [
                    'subject'   => 'Account Confirmation',
                    'greetings' => 'Hello :name',
                    'body'      => 'Please access the link below to confirm your account.',
                    'farewell'  => 'Regards',
                ],
                'password_reset'       => [
                    'subject'   => 'Password Reset',
                    'greetings' => 'Hello :name',
                    'body'      => 'Access the following link to change your password',
                    'farewell'  => 'Regards',
                ],
            ],
        ],
    ];


    $english =   [
        'contact_us'   => 'Contact Us',
        'nav'          => [
            'home'          => 'Home',
            'admin'         => 'Admin',
            'login'         => 'Login',
            'logout'        => 'Logout',
            'register'      => 'Register',
            'main'          => 'Main Page',
            'events'        => 'Events',
            'consultancies' => 'Consultancies',
            'posts'         => 'Blog',
            'contactus'     => 'Contact Us',
            'search'        => 'Search',
            'username'      => 'Username',
            'password'      => 'Password',
            'email'         => 'Email',
            'package'       => 'Package'
        ],
        'event'        => [
            'summaryevent'         => 'Summary',
            'totalseats'           => 'Total Seats',
            'date_start'           => 'Starts on',
            'time_start'           => 'Starts at',
            'seatsavail'           => 'Seats Available.',
            'date_end'             => 'Ends on',
            'time_end'             => 'Ends at',
            'favorite'             => 'Add To Favorites',
            'unfavorite'           => 'Remove From Favorites',
            'follow'               => 'Follow',
            'unfollow'             => 'Unfollow',
            'subscribe'            => 'Join',
            'unsubscribe'          => 'Unsubscribe',
            'comment'              => 'Comments',
            'addcomment'           => 'Add Comment',
            'category'             => 'Category',
            'title'                => 'Title',
            'events'               => 'Events',
            'all'                  => 'All',
            'choose_country'       => 'Select Country',
            'choose_category'      => 'Select Category',
            'choose_author'        => 'Select Author',
            'price'                => 'Event Price',
            'free'                 => 'Free',
            'unsubscribe_btn_desc' => 'Cancel Subscription',
            'reorganize'           => 'Request to Reorganize The Event',
            'online'               => 'Enter Online Room'
        ],
        'general'      => [
            'kaizen'               => 'Kaizen',
            'email'                => 'Email',
            'submit'               => 'Submit',
            'comment'              => 'Comment',
            'remember'             => 'Remember',
            'latest_events'        => 'Latest Events',
            'latest_blog'          => 'Latest Blog Posts',
            'newsletter'           => 'Newsletter',
            'instagram'            => 'Instagram',
            'twitter'              => 'Twitter',
            'youtube'              => 'Youtube',
            'newsletter_subscribe' => 'Subscribe to Newletter',
            'youlog'               => 'You are logged as',
            'profile'              => 'Profile',
            'username'             => 'Username',
            'name'                 => 'Name',
            'gender'               => 'Sex',
            'phone'                => 'Phone',
            'mobile'               => 'Mobile',
            'country_code'         => 'Country Code',
            'country'              => 'Country',
            'location'             => 'Location',
            'dob'                  => 'Date of Birth',
            'admin_panel'          => 'Admin Panel',
            'notavail'             => 'N/A',
            'fix_error'            => 'Please Fix these errors and try again ..',
            'first_name'           => 'Full Name - English',
            'last_name'            => 'Full Name - Arabic',
            'pass'                 => 'Password',
            'pass_confirm'         => 'Password Confirmation',
            'telelphone'           => 'Telephone',
            'select_country'       => 'Country',
            'birth'                => 'Birth Day',
            'male'                 => 'Male',
            'female'               => 'Female',
            'more'                 => 'More...',
            'entry'                => 'Login to your account',
            'subscribe_btn_desc'   => 'Book a Seat',
            'follow_btn_desc'      => 'Follow Event',
            'fv_btn_desc'          => 'Add to Favorite',
            'prev_events'          => 'Did you attend any previous events in Kaizen .. please tell us what events and where ... Thank You',
            'warning_msg'          => 'Please kindly note that these information are important in order to issue your certificates in the future.. please fill in the form properly',
            'settings'             => 'Settings',
            'address'              => 'Address',
            'vip'                  => 'VIP',
            'online'               => 'Online',
            'normal'               => 'Normal',
            'system-error'         => 'System Error',
            'event-expired'        => 'Sorry, This Event is Expired',
            'check-email'          => 'We have sent you an Email with the Details about your Subscription.',
            'cannot-watch'         => 'You Cannot Watch this event now',
            'event-ongoing'        => 'This Event is Ongoing at present',
            'no-stream'            => 'There is no online stream for this event',
            'not-confirmed'        => 'Your Subscription is not confirmed.',
            'not-online'           => 'You are not subscribed to this event as ONLINE',
            'no-results'           => 'لا يوجد نتائج',
            'keyword'              => 'Keyword',
            'favorites'            => 'مفضلات',
            'subscriptions'        => 'حجزات',
            'followings'           => 'متابعات',
        ],
        'subscription' => [
            'subscribed'         => 'You :attribute this event',
            'unsubscribed'       => 'You :attribute this event',
            'already_subscribed' => 'You  already :attribute this event',
            'not_authenticated'  => 'Sorry, You must sign in before you perform this action',
            'wrong_access'       => 'Sorry, Wrong Acces',
            'error'              => 'Sorry, Could not :attribute you',
            'not_subscribed'     => 'Sorry, you havent :attribute this event in first place',
            'rejected'           => 'Sorry, You cannot Register this event',
            'requested'          => 'Your Request For Re-organizing the Event has been sent to the Admin.',
            'followed'           => 'You followed this event.',
            'unfollowed'         => 'You unfollowed this event.',
            'favorited'          => 'You favorited this event.',
            'unfavorited'        => 'You unfavorited this event.',
        ],
        'auth'         => [
            'username'              => 'Username',
            'password'              => 'Password',
            'password_confirmation' => 'Confirm Password',
            'e_mail'                => 'Email',
            'username_e_mail'       => 'Username or Email',
            'signup'                => [
                'title'                 => 'Signup',
                'desc'                  => 'Signup for new account',
                'confirmation_required' => 'Confirmation required',
                'submit'                => 'Create new account',
            ],
            'login'                 => [
                'title'           => 'Login',
                'desc'            => 'Enter your credentials',
                'forgot_password' => 'Forgot Password',
                'remember'        => 'Remember me',
                'submit'          => 'Login',
            ],
            'forgot'                => [
                'title'  => 'Forgot password',
                'submit' => 'Continue',
            ],
            'alerts'                => [
                'account_created'        => 'Your account has been successfully created. Please check your email for the instructions on how to confirm your account.',
                'too_many_attempts'      => 'Too many attempts. Try again in few minutes.',
                'wrong_credentials'      => 'Incorrect username, email or password.',
                'not_confirmed'          => 'Your account may not be confirmed. Check your email for the confirmation link',
                'confirmation'           => 'Your account has been confirmed! You may now login.',
                'wrong_confirmation'     => 'Wrong confirmation code.',
                'password_forgot'        => 'The information regarding password reset was sent to your email.',
                'wrong_password_forgot'  => 'User not found.',
                'password_reset'         => 'Your password has been changed successfully.',
                'wrong_password_reset'   => 'Invalid password. Try again',
                'wrong_token'            => 'The password reset token is not valid.',
                'duplicated_credentials' => 'The credentials provided have already been used. Try with different credentials.',
            ],
            'email'                 => [
                'account_confirmation' => [
                    'subject'   => 'Account Confirmation',
                    'greetings' => 'Hello :name',
                    'body'      => 'Please access the link below to confirm your account.',
                    'farewell'  => 'Regards',
                ],
                'password_reset'       => [
                    'subject'   => 'Password Reset',
                    'greetings' => 'Hello :name',
                    'body'      => 'Access the following link to change your password',
                    'farewell'  => 'Regards',
                ],
            ],
        ],
    ];

});
