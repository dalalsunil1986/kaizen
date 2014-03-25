<?php

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UserController extends BaseController {

    /**
     * User Model
     * @var User
     */
    protected $user;
    protected $layout = 'site.layouts.home';
    /**
     * Inject the models.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        parent::__construct();
    }

    /**
     * Users settings page
     *
     * @return View
     */
    public function index()
    {
        list($user,$redirect) = $this->user->checkAuthAndRedirect('user');
        if($redirect){return $redirect;}

        // Show the page
        return View::make('site/user/index', compact('user'));
    }

    /**
     * Stores new user
     *
     */
    public function store()
    {
        $this->user->username = Input::get( 'username' );
        $this->user->email = Input::get( 'email' );
        $password = Input::get( 'password' );
        $passwordConfirmation = Input::get( 'password_confirmation' );
        $this->user->first_name = Input::get('first_name');
        $this->user->last_name = Input::get('last_name');
        $this->user->mobile = Input::get('mobile');
        $this->user->phone = Input::get('phone');
        $this->user->country = Input::get('country');
        $this->user->twitter = Input::get('twitter');
        $this->user->instagram = Input::get('instagram');
        $this->user->prev_event_comment = Input::get('prev_event_comment');

        if(!empty($password)) {
            if($password === $passwordConfirmation) {
                $this->user->password = $password;
                // The password confirmation will be removed from model
                // before saving. This field will be used in Ardent's
                // auto validation.
                $this->user->password_confirmation = $passwordConfirmation;
            } else {
                // Redirect to the new user page
                return Redirect::back()
                    ->withInput(Input::except('password','password_confirmation'))
                    ->with('error', Lang::get('admin/users/messages.password_does_not_match'));
            }
        } else {
            unset($this->user->password);
            unset($this->user->password_confirmation);
        }
        // Save if valid. Password field will be hashed before save
        if($this->user->save()) {
            // Redirect with success message, You may replace "Lang::get(..." for your custom message.
            return Redirect::to('/')
                ->with( 'notice', Lang::get('user/user.user_account_created') );

        }
        else
        {
            // Get validation errors (see Ardent package)
            $errors = $this->user->errors();
            return Redirect::back()
                ->withInput(Input::except('password'))
                ->withErrors($errors );
        }
    }

    public function show($id) {
        return $this->getProfile($id);
    }


    public function edit($id) {
        $user = $this->user->find($id);
        $this->layout->nav = view::make('site.layouts.nav');
        $this->layout->maincontent = view::make('site.user.edit',compact('user'));
        $this->layout->sidecontent = view::make('site.layouts.sidebar');
        $this->layout->footer = view::make('site.layouts.footer');
    }

    /**
     * Edits a user
     *
     */
    public function update($user)
    {
        $oldUser = clone $user;
        $rules = array(
            'password' => 'sometimes|between:4,11|confirmed',
            'password_confirmation' => 'between:4,11',
            'first_name' => 'alpha|between:3,10',
            'last_name' =>  'alpha|between:3,10',
            'mobile' =>   'numeric',
            'phone' =>    'numeric',
            'twitter' =>    'url',
            'instagram' =>   'url',
            'prev_event_comment' =>  'min:5'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);
        $password = Input::get('password');
        $passwordConfirmation = Input::get('password_confirmation');

        if(!empty($password)) {
//            dd('password is not empty'); //true
            if($password === $passwordConfirmation) {
//                dd('password matches'); // true

                $user->password = $password;
                // The password confirmation will be removed from model
                // before saving. This field will be used in Ardent's
                // auto validation.
                $user->password_confirmation = $passwordConfirmation;
            } else {
//                dd('password does not match'); //true

                // Redirect to the new user page
                return Redirect::back()->with('error', Lang::get('admin/users/messages.password_does_not_match'));
            }
        } else {
//            dd('password is empty'); //true
            unset($user->password);
            unset($user->password_confirmation);
        }
        if ($validator->passes())
        {

            return Redirect::action('UserController@getProfile',$user->id)
                ->with( 'success', Lang::get('user/user.user_account_updated') );
        } else {
            $error = $validator->errors()->all();
            return Redirect::back()
                ->withInput(Input::except('password','password_confirmation'))
                ->with('error', $error );
        }
    }


    /**
     * Displays the form for user creation
     *
     */
    public function create()
    {
        $this->layout->nav = view::make('site.layouts.nav');
        $this->layout->maincontent = view::make('site.user.create');
        $this->layout->sidecontent = view::make('site.layouts.sidebar');
        $this->layout->footer = view::make('site.layouts.footer');
    }

    /**
     * Displays the login form
     *
     */
    public function getLogin()
    {
        $user = Auth::user();
        if(!empty($user->id)){
            return Redirect::to('/');
        }
        $this->layout->nav = view::make('site.layouts.nav');
        $this->layout->maincontent = view::make('site.user.login');
        $this->layout->sidecontent = view::make('site.layouts.sidebar');
        $this->layout->footer = view::make('site.layouts.footer');
    }

    /**
     * Attempt to do login
     *
     */
    public function postLogin()
    {
        $input = array(
            'email'    => Input::get( 'email' ), // May be the username too
            'username' => Input::get( 'email' ), // May be the username too
            'password' => Input::get( 'password' ),
            'remember' => Input::get( 'remember' ),
        );
        // If you wish to only allow login from confirmed users, call logAttempt
        // with the second parameter as true.
        // logAttempt will check if the 'email' perhaps is the username.
        // Check that the user is confirmed.
        if ( Confide::logAttempt( $input, true ) )
        {
            return Redirect::intended('/');
        }
        else
        {
            // Check if there was too many login attempts
            if ( Confide::isThrottled( $input ) ) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ( $this->user->checkUserExists( $input ) && ! $this->user->isConfirmed( $input ) ) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            return Redirect::intended(LaravelLocalization::localizeUrl('user/login'))
                ->withInput(Input::except('password'))
                ->with('error', $err_msg );

        }
    }

    /**
     * Attempt to confirm account with code
     *
     * @param  string $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getConfirm( $code )
    {
        if ( Confide::confirm( $code ) )
        {
            return Redirect::to('user/login')
                ->with( 'notice', Lang::get('confide::confide.alerts.confirmation') );
        }
        else
        {
            return Redirect::to('user/login')
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_confirmation') );
        }
    }

    /**
     * Displays the forgot password form
     *
     */
    public function getForgot()
    {
        $this->layout->nav = view::make('site.layouts.nav');
        $this->layout->maincontent = view::make('site.user.forgot');
        $this->layout->sidecontent = view::make('site.layouts.sidebar');
        $this->layout->footer = view::make('site.layouts.footer');
    }

    /**
     * Attempt to reset password with given email
     *
     */
    public function postForgot()
    {
        if( Confide::forgotPassword( Input::get('email') ) )
        {
            return Redirect::to('user/login')
                ->with( 'notice', Lang::get('confide::confide.alerts.password_forgot') );
        }
        else
        {
            return Redirect::to('user/forgot')
                ->withInput()
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_password_forgot') );
        }
    }

    /**
     * Shows the change password form with the given token
     *
     */
    public function getReset( $token )
    {
        $this->layout->nav = view::make('site.layouts.nav');
        $this->layout->maincontent = view::make('site.user.reset', ['token'=>$token]);
        $this->layout->sidecontent = view::make('site.layouts.sidebar');
        $this->layout->footer = view::make('site.layouts.footer');
    }


    /**
     * Attempt change password of the user
     *
     */
    public function postReset()
    {
        $input = array(
            'token'=>Input::get( 'token' ),
            'password'=>Input::get( 'password' ),
            'password_confirmation'=>Input::get( 'password_confirmation' ),
        );

        // By passing an array with the token, password and confirmation
        if( Confide::resetPassword( $input ) )
        {
            return Redirect::to('user/login')
                ->with( 'notice', Lang::get('confide::confide.alerts.password_reset') );
        }
        else
        {
            return Redirect::to('user/reset/'.$input['token'])
                ->withInput()
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_password_reset') );
        }
    }

    /**
     * Log the user out of the application.
     *
     */
    public function getLogout()
    {
        Confide::logout();

        return Redirect::to('/');
    }

    /**
     * Get user's profile
     * @param $username
     * @return mixed
     */
    public function getProfile($id)
    {
//        Post::with(array('user'=>function($query){
//                $query->select('id','username');
//            }))->get();
        $user = $this->user->find($id)->with(array('favorites','subscriptions','followings'))->first();
        // Check if the user exists
        if (is_null($user))
        {
            return App::abort(404);
        }
        $this->layout->login = View::make('site.layouts.login');
        $this->layout->nav = view::make('site.layouts.nav');
        $this->layout->sidecontent = view::make('site.layouts.sidebar');
        $this->layout->maincontent = View::make('site/user/profile', compact('user'));
        $this->layout->footer = view::make('site.layouts.footer');

    }

    public function getSettings()
    {
        list($user,$redirect) = User::checkAuthAndRedirect('user/settings');
        if($redirect){return $redirect;}

         View::make('site/user/profile', compact('user'));
    }

    /**
     * Process a dumb redirect.
     * @param $url1
     * @param $url2
     * @param $url3
     * @return string
     */
    public function processRedirect($url1,$url2,$url3)
    {
        $redirect = '';
        if( ! empty( $url1 ) )
        {
            $redirect = $url1;
            $redirect .= (empty($url2)? '' : '/' . $url2);
            $redirect .= (empty($url3)? '' : '/' . $url3);
        }
        return $redirect;
    }
}
