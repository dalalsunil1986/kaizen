<?php namespace Acme\Refund;

use Acme\Core\Repositories\AbstractRepository;
use Acme\Core\Repositories\Illuminate;
use Refund;

class RefundRepository extends AbstractRepository {

    /**
     * @param Refund $model
     */
    public function __construct(Refund $model)
    {
        $this->model = $model;
    }

}