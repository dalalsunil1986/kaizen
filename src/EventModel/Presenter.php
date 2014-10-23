<?php namespace Acme\EventModel;

use Acme\Core\AbstractPresenter;
use App;
use Country;
use EventModel;
use Session;
use User;

class Presenter extends AbstractPresenter {

    /**
     * Present the created_at property
     * using a different format
     *
     * @param \Acme\EventModel\EventModel|\User $model
     */
    public $resource;

    public function __construct(EventModel $model)
    {
        $this->resource = $model;
    }

    public function date_start()
    {
        return $this->resource->date_start->format('Y-m-d H:i');
    }

    public function date_end()
    {
        return $this->resource->date_end->format('Y-m-d H:i');
    }

    public function price()
    {
        $iso       = Session::get('user.country');
        if ($iso == 'KW') {
            return $this->resource->price . ' KD';
        }

        $converter = App::make('Acme\Libraries\UserCurrency');
        $country   = Country::where('iso_code', $iso)->first();

        if($country) {

            return $converter->convert($country->currency, $this->resource->price) . ' ' . $country->currency;
        } else {
            return $this->resource->price . ' KD';
        }
//        if ( $country->iso_code == $iso ) return $this->resource->price . ' ' . $country->currency;

    }

}
