<?php namespace Acme\Country;

use Acme\Core\CrudableTrait;
use Country;
use Illuminate\Support\MessageBag;
use Acme\Core\Repositories\Illuminate;
use Acme\Core\Repositories\AbstractRepository;

class CountryRepository extends AbstractRepository  {

    use CrudableTrait;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    public function __construct(Country $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

    public function getByIso($isoCode){
        return $this->model->where('iso_code',$isoCode)->first();
    }
}