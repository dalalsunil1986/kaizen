<?php 

return array(

	/*
	|--------------------------------------------------------------------------
	| Site Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines are used by the paginator library to build
	| the simple pagination links. You are free to change them to anything
	| you want to customize your views to better match your application.
	|
	*/

	'contact_us' => 'Contact Us',

    'nav' => array('home' => 'Home','admin' => 'Admin','login' => 'Login', 'logout'=>'Logout','register' => 'Register',
                    'main' => 'Main Page',
                    'events' => 'Events',
                    'consultancies' => 'Consultancies',
                    'posts' => 'Blog',
                    'contactus' => 'Contact Us',
                    'search' => 'Search',
                    'username' => 'Username',
                    'password' => 'Password',
                    'email' => 'Email'

    ),
    'event' => array(
                'summaryevent' => 'Summary',
                'totalseats' => 'Total Seats',
                'date_start' => 'Starts on',
                'time_start' => 'Starts at',
                'seatsavail' => 'Seats Available.',
                'date_end' => 'Ends on',
                'time_end' => 'Ends at',
                'favorite' => 'Add To Favorites',
                'unfavorite' => 'Remove From Favorites',
                'follow' => 'Follow',
                'unfollow' => 'Unfollow',
                'subscribe' => 'Join',
                'unsubscribe'=>'Unsubscribe',
                'comment' => 'Comments' ,
                'addcomment' => 'Add Comment',
                'category' => 'Category',
                'title' => 'Title',
                'events' => 'Events',
                'all' => 'All',
                'choose_country'=>'Select Country',
                'choose_category'=> 'Select Category',
                'choose_author'=> 'Select Author',
                'price' => 'Event Price',
                'free' => 'Free',
                'unsubscribe_btn_desc' => 'Cancel Subscription'

                ),
    'general' => array(
                'kaizen' => 'Kaizen',
                'name' => 'Name',
                'email' => 'Email',
                'submit' => 'Submit',
                'comment' => 'Comment',
                'remember' => 'Remember',
                'latest_events' => 'Latest Events',
                'latest_blog' => 'Latest Blog Posts',
                'newsletter' => 'Newsletter',
                'instagram' =>'Instagram',
                'twitter' => 'Twitter',
                'youtube' => 'Youtube',
                'newsletter_subscribe' => 'Subscribe to Newletter',
                'youlog' => 'You are logged as',
                'profile' => 'Profile',
                'username'=>'Username',
                'name' => 'Name',
                'gender'=> 'Sex',
                'phone' => 'Phone',
                'mobile'=> 'Mobile',
                'country' => 'Country',
                'location' => 'Location',
                'dob'=> 'Date of Birth',
                'admin_panel'=> 'Admin Panel',
                'notavail' => 'N/A',
                'fix_error' => 'Please Fix these errors and try again ..',
                'first_name' => 'Full Name - English',
                'last_name' =>'Full Name - Arabic',
                'pass' =>'Password',
                'pass_confirm' =>'Password Confirmation',
                'mobile' =>'Mobile',
                'telelphone'=>'Telephone',
                'select_country' => 'Country',
                'birth' => 'Birth Day',
                'gender' => 'Gender',
                'male' =>'Male',
                'female' => 'Female',
                'more' => 'More...',
                'entry' => 'Login to your account',
                'subscribe_btn_desc' => 'Book a Seat',
                'follow_btn_desc' => 'Follow Event',
                'fv_btn_desc' => 'Add to Favorite',
                'prev_events' => 'Did you attend any previous events in Kaizen .. please tell us what events and where ... Thank You',
                'warning_msg' => 'Please kindly note that these information are important in order to issue your certificates in the future.. please fill in the form properly',
                'settings' => 'Settings',
                'address' => 'Address',
                'vip' => 'VIP',
                'online' => 'Online',
                'normal' => 'Normal'
    ),
    'subscription' => array(
        'subscribed' => 'You :attribute this event',
        'unsubscribed' => 'You :attribute this event',
        'already_subscribed' => 'You  already :attribute this event',
        'not_authenticated' => 'Sorry, You must sign in before you perform this action',
        'wrong_access'=> 'Sorry, Wrong Acces',
        'error'=> 'Sorry, Could not :attribute you',
        'not_subscribed' => 'Sorry, you havent :attribute this event in first place',
        'rejected' => 'Sorry, You cannot Register this event'
    ),

    'auth' => array(
        'username' => 'Username',
        'password' => 'Password',
        'password_confirmation' => 'Confirm Password',
        'e_mail' => 'Email',
        'username_e_mail' => 'Username or Email',

        'signup' => array(
            'title' => 'Signup',
            'desc' => 'Signup for new account',
            'confirmation_required' => 'Confirmation required',
            'submit' => 'Create new account',
        ),

        'login' => array(
            'title' => 'Login',
            'desc' => 'Enter your credentials',
            'forgot_password' => 'Forgot Password',
            'remember' => 'Remember me',
            'submit' => 'Login',
        ),

        'forgot' => array(
            'title' => 'Forgot password',
            'submit' => 'Continue',
        ),

        'alerts' => array(
            'account_created' => 'Your account has been successfully created. Please check your email for the instructions on how to confirm your account.',
            'too_many_attempts' => 'Too many attempts. Try again in few minutes.',
            'wrong_credentials' => 'Incorrect username, email or password.',
            'not_confirmed' => 'Your account may not be confirmed. Check your email for the confirmation link',
            'confirmation' => 'Your account has been confirmed! You may now login.',
            'wrong_confirmation' => 'Wrong confirmation code.',
            'password_forgot' => 'The information regarding password reset was sent to your email.',
            'wrong_password_forgot' => 'User not found.',
            'password_reset' => 'Your password has been changed successfully.',
            'wrong_password_reset' => 'Invalid password. Try again',
            'wrong_token' => 'The password reset token is not valid.',
            'duplicated_credentials' => 'The credentials provided have already been used. Try with different credentials.',
        ),

        'email' => array(
            'account_confirmation' => array(
                'subject' => 'Account Confirmation',
                'greetings' => 'Hello :name',
                'body' => 'Please access the link below to confirm your account.',
                'farewell' => 'Regards',
            ),

            'password_reset' => array(
                'subject' => 'Password Reset',
                'greetings' => 'Hello :name',
                'body' => 'Access the following link to change your password',
                'farewell' => 'Regards',
            ),
        ),
    ),

);
