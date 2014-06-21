<?php namespace Acme\Events;

use Acme\Users\UserRepository;
use EventModel;
use Illuminate\Support\MessageBag;
use Acme\Core\Repositories\Crudable;
use Acme\Core\Repositories\Illuminate;
use Acme\Core\Repositories\Paginable;
use Acme\Core\Repositories\Repository;
use Acme\Core\Repositories\AbstractRepository;

class EloquentEventRepository extends AbstractRepository implements Repository, Paginable, Crudable, UserRepository {

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * Construct
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @internal param \Illuminate\Database\Eloquent\Model $user
     */
    public function __construct(EventModel $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

    public function findAll($perPage = 5)
    {
        $events = $this->model->with(array('category', 'location.country', 'photos', 'author'));

        return $events;


//        return $events;
    }

    /**
     * Create a new entity
     *
     * @param array $input
     * @internal param array $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create(array $input)
    {
        return $this->model->create($input);
    }

    /**
     * Update an existing entity
     *
     * @param array $input
     * @internal param array $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function update(array $input)
    {
        // TODO: Implement update() method.
    }

    /**
     * Delete an existing entity
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }


}