<?php namespace Acme\Country;

use Acme\Core\CrudableTrait;
use App;
use Auth;
use Country;
use Illuminate\Support\MessageBag;
use Acme\Core\Repositories\Illuminate;
use Acme\Core\Repositories\AbstractRepository;
use Session;

class CountryRepository extends AbstractRepository {

    use CrudableTrait;

    public $default = 'Kuwait';
    public $defaultCurrency = 'KWD';

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    public function __construct(Country $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

    public function getByIso($isoCode)
    {
        return $this->model->where('iso_code', $isoCode)->first();
    }

    public function availableCountries()
    {
        return $this->getAll();
    }

    public function setRegion()
    {
        if ( Session::has('user.country') ) {
            $country = Session::get('user.country');
        } elseif ( Auth::check() ) {
            if ( !is_null(Auth::user()->country) ) {
                $countryId = Auth::user()->country_id;
                if ( $country = Country::find($countryId) ) {
                    $country = $country->iso_code;
                    Session::put('user.country', $country);
                }
            }
        }

        if ( empty($country) ) {
            // find by IP
            $class   = App::make('Acme\Libraries\UserGeoIp');
            $country = $class->getCountry();
            Session::put('user.country', $country);
        }

        if ( empty($country) ) {
            $country = $this->default;
            Session::put('user.country', $country);
        }

        return $country;
    }
}