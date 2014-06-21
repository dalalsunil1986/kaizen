<?php namespace Acme\Users;

use Illuminate\Support\MessageBag;
use Acme\Core\Repositories\Crudable;
use Acme\Core\Repositories\Illuminate;
use Acme\Core\Repositories\Paginable;
use Acme\Core\Repositories\Repository;
use Acme\Core\Repositories\AbstractRepository;
use User;

class EloquentUserRepository extends AbstractRepository implements Repository, Paginable, Crudable{

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
    public function __construct(User $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
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

    public static function isSubscribed($id,$userId) {
        $query = Subscription::where('user_id', '=', $userId)->where('event_id', '=', $id)->count();
        return ($query >= 1 ) ? true : false;
    }

    public function getRoleByName($roleName) {
        $query=  $this->model->with('roles')->whereHas('roles', function($q) use ($roleName)
        {
            $q->where('name', '=', $roleName);

        })->get();
        return $query;
    }


}