<?php namespace Acme\Location;

use Acme\Core\CrudableTrait;
use Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\MessageBag;
use Acme\Core\Repositories\Illuminate;
use Acme\Core\Repositories\AbstractRepository;
use Location;

class LocationRepository extends AbstractRepository {

    use CrudableTrait;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * Construct
     *
     * @param \Country|\Illuminate\Database\Eloquent\Model $model
     * @internal param \Illuminate\Database\Eloquent\Model $user
     */
    public function __construct(Location $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

}