<?php namespace Acme\Tag;

use Acme\Core\CrudableTrait;
use Acme\Core\Repositories\Illuminate;
use Acme\Core\Repositories\AbstractRepository;
use Tag;

class TagRepository extends AbstractRepository {

    use CrudableTrait;

    public $model;

    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

}