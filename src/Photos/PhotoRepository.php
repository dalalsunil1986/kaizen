<?php namespace Acme\Photos;

use Acme\Core\CrudableTrait;
use Illuminate\Support\MessageBag;
use Acme\Core\Repositories\Crudable;
use Acme\Core\Repositories\Illuminate;
use Acme\Core\Repositories\AbstractRepository;
use Photo;

class PhotoRepository extends AbstractRepository {

    use CrudableTrait;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * Construct
     *
     * @param \Illuminate\Database\Eloquent\Model|\Photo $model
     * @internal param \Illuminate\Database\Eloquent\Model $user
     */
    public function __construct(Photo $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

}