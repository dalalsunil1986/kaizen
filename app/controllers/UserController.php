<?php

use Acme\Events\CountryRepository;
use Acme\Users\UserRepository;

class UserController extends BaseController {

    /**
     * User Model
     * @var User
     */
    protected $userRepository;
    /**
     * @var Acme\Events\CountryRepository
     */
    private $countryRepository;

    /**
     * Inject the models.
     * @param \Acme\Users\UserRepository|\User $userRepository
     * @param Acme\Events\CountryRepository $countryRepository
     */
    public function __construct(UserRepository $userRepository, CountryRepository $countryRepository)
    {
        $this->userRepository = $userRepository;
        $this->countryRepository = $countryRepository;
        parent::__construct();
    }

    /**
     * Users settings page
     *
     * @return View
     */
    public function index()
    {
        list($user, $redirect) = $this->userRepository->checkAuthAndRedirect('user');
        if ( $redirect ) {
            return $redirect;
        }

        // Show the page
        return View::make('site/user/index', compact('user'));
    }

    /**
     * @param $id
     * @return redirect to get profile
     * just a RESTful wrapper
     */
    public function show($id)
    {
        return $this->getProfile($id);
    }

    /**
     * Get user's profile
     * @param $id
     * @internal param $username
     * @return mixed
     */
    public function getProfile($id)
    {
        $user = $this->userRepository->requireById($id, ['favorites', 'subscriptions', 'followings', 'country']);
        $this->render('site.users.profile', compact('user'));
    }

    /**
     * Edit Profile
     */
    public function edit($id)
    {
        $user      = $this->userRepository->requireById($id);
        $countries = $this->countryRepository->getAll()->lists('name_en', 'id');
        $this->render('site.users.edit', compact('user', 'countries'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * Update Profile
     */
    public function update($id)
    {
        $this->userRepository->requireById($id);

        $data = Input::only('name_ar', 'name_en', 'password', 'country_id', 'twitter', 'phone', 'mobile');

        $val = $this->userRepository->validators['update']->with($data);

        if ( $val->passes() ) {
            if ( $user = $this->userRepository->update(id, $data) ) {
                return Redirect::action('UserController@getProfile', $id)->with('success', 'Updated');
            } else {
                return Redirect::back()->with('errors', $this->userRepository->errors())->withInput();
            }
        } else {
            return Redirect::back()->with('errors', $val->errors())->withInput();
        }
    }

    public function destroy($id)
    {
        $user = $this->userRepository->requireById($id);

        if ( $this->userRepository->delete($user) ) {
            return Redirect::home()->with('success', 'Account Deleted');
        }

        return Redirect::back('/')->with('errors', 'Could Not Delete Account.');

    }

}
