<?php namespace Acme\Package;

use Acme\Core\CrudableTrait;
use Acme\Core\Repositories\AbstractRepository;
use Acme\Core\Repositories\Illuminate;
use Package;

class PackageRepository extends AbstractRepository {

    use CrudableTrait;

    public $model;

    public function __construct(Package $model)
    {
        $this->model = $model;
    }

}