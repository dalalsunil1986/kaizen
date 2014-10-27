<?php

use Acme\Country\CountryRepository;
use Acme\Libraries\UserGeoIp;
use Acme\User\AuthService;
use Acme\User\UserRepository;

class AuthController extends BaseController {

    /**
     * @var AuthRepository
     */
    private $service;
    /**
     * @var CountryRepository
     */
    private $countryRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param AuthService $service
     * @param CountryRepository $countryRepository
     * @param UserRepository $userRepository
     */
    public function __construct(AuthService $service, CountryRepository $countryRepository, UserRepository $userRepository)
    {
        $this->service = $service;
        parent::__construct();

        // restrict authenticated users from pages except logout
        $this->beforeFilter('noAuth', ['except'=> ['getLogout']]);
        $this->countryRepository = $countryRepository;
        $this->userRepository = $userRepository;
    }

    public function getLogin()
    {
        $this->title = 'Login to your Account';
        $this->render('site.auth.login');
    }

    public function postLogin()
    {
        $email    = Input::get('email');
        $password = Input::get('password');
        $remember = Input::has('remember') ? true : false;

        if ( ! Auth::attempt(array('email' => $email, 'password' => $password, 'active' => 1), $remember) ) {

            return Redirect::action('AuthController@getLogin')->with('error', 'Wrong Username Password');
        }

        $this->service->updateLastLoggedAt();

        return Redirect::intended('/');
    }


    /**
     * User Registeration Page
     */
    public function getSignup()
    {
        $this->title = 'Create an Account';
        $this->render('site.auth.signup');
        // $this->postRegister();
    }


    public function postSignup()
    {
        // get the registration form
        $val = $this->service->getRegistrationForm();

        // check if the form is valid
        if ( ! $val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        // If Auth Sevice Fails to Register the User
        if ( ! $this->service->register($val->getInputData()) ) {

            return Redirect::home()->with('errors', $this->service->errors());
        }

//        $user_country = new UserGeoIp($this->userRepository);
//        $country = $this->countryRepository->getByIso($user_country);
//        dd($country);

        // If User got Registered
        return Redirect::action('AuthController@getLogin')->with('success', 'Email confirmation link has been sent to your email. PLease confirm your account');

    }

    /**
     * Display The  Forgot Password Form
     * @return Response
     */
    public function getForgot()
    {
        $this->title = 'Reset Password';
        $this->render('site.auth.forgot');
    }

    /**
     * Handle a POST request to remind a user of their password.
     *
     * @return Response
     */
    public function postForgot()
    {
        switch ( $response = Password::remind(Input::only('email')) ) {
            case Password::INVALID_USER:
                return Redirect::back()->with('error', Lang::get($response));

            case Password::REMINDER_SENT:
                return Redirect::back()->with('success', Lang::get($response));
        }
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string $token
     * @return Response
     */
    public function getReset($token = null)
    {
        if ( is_null($token) ) App::abort(404);

        $this->render('site.auth.reset', array('token' => $token));
    }

    /**
     * Handle a POST request to reset a user's password.
     *
     * @return Response
     */
    public function postReset()
    {
        $credentials = Input::only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = $this->service->resetPassword($credentials);

        switch ( $response ) {
            case Password::INVALID_PASSWORD:
            case Password::INVALID_TOKEN:
            case Password::INVALID_USER:
                return Redirect::back()->with('error', Lang::get($response))->withInput();

            case Password::PASSWORD_RESET:
                return Redirect::action('AuthController@getLogin')->with('success', 'Your Password Has been Reset');
        }
    }

    /**
     * Logout a User
     */
    public function getLogout()
    {
        Auth::logout();

        return Redirect::home();
    }

    /**
     * @param $token
     * Confirm the User and Activate
     * Lands on this page When User Clicks the Activation Link in Email
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate($token)
    {
        // If not activated ( errors )
        if (! $this->service->activateUser($token) ) {

            return Redirect::home()->with('errors', $this->service->errors());
        }
        // redirect to home with active message
        return Redirect::action('AuthController@getLogin')->with('success', 'Your account is activated, please login');

    }

}