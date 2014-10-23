<?php

class LocaleController extends BaseController {

    /**
     * @var \Acme\User\UserRepository
     */
    private $userRepository;
    /**
     * @var \Acme\Country\CountryRepository
     */
    private $countryRepository;

    /**
     * @param \Acme\User\UserRepository $userRepository
     * @param \Acme\Country\CountryRepository $countryRepository
     */
    public function __construct(\Acme\User\UserRepository $userRepository, \Acme\Country\CountryRepository $countryRepository)
    {
        parent::__construct();
        $this->userRepository    = $userRepository;
        $this->countryRepository = $countryRepository;
    }

    public function setCountry($country)
    {
        Session::put('user.country', $country);

        if ( Auth::check() ) {
            $user    = Auth::user();
            $country = $this->countryRepository->model->where('iso_code', $country)->first();
            if ( $country ) {
                $user->country_id = $country->id;
                $user->save();
            }
        }

        return Redirect::back();
    }

}