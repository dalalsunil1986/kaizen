<?php

use Acme\Country\CountryRepository;
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
     * @param \Acme\Country\CountryRepository|\Acme\Events\CountryRepository $countryRepository
     */
    public function __construct(UserRepository $userRepository, CountryRepository $countryRepository)
    {
        $this->userRepository    = $userRepository;
        $this->countryRepository = $countryRepository;
        parent::__construct();
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

        $val = $this->userRepository->getEditForm($id);

        if ( ! $val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if (! $this->userRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->userRepository->errors())->withInput();
        }

        return Redirect::action('UserController@getProfile', $id)->with('success', 'Updated');
    }

    public function destroy($id)
    {
        $user = $this->userRepository->requireById($id);

        if ( $this->userRepository->delete($user) ) {

            return Redirect::home()->with('success', 'Account Deleted');
        }

        return Redirect::back('/')->with('errors', 'Could Not Delete Account.');
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


}
