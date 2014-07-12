<?php namespace Acme\Subscription;

use Acme\Core\CrudableTrait;
use Acme\Core\Repositories\AbstractRepository;
use Acme\Core\Repositories\Illuminate;
use Setting;

class SubscriptionRepository extends AbstractRepository {

    use CrudableTrait;

    public $model;

    public function __construct(Subscription $model)
    {
        $this->model = $model;
    }

}