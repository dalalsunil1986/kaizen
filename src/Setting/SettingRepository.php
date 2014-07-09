<?php namespace Acme\Setting;

use Acme\Core\CrudableTrait;
use Acme\Core\Repositories\AbstractRepository;
use Acme\Core\Repositories\Illuminate;
use Setting;

class SettingRepository extends AbstractRepository {

    use CrudableTrait;

    public $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

}