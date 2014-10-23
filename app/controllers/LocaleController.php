<?php

use Acme\Country\CountryRepository;
use Acme\User\UserRepository;

class LocaleController extends BaseController {

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * @param UserRepository $userRepository
     * @param CountryRepository $countryRepository
     */
    public function __construct(UserRepository $userRepository, CountryRepository $countryRepository)
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