<?php namespace Acme\Users;

use Acme\Core\CrudableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\MessageBag;
use Acme\Core\Repositories\Illuminate;
use Acme\Core\Repositories\Paginable;
use Acme\Core\Repositories\Repository;
use Acme\Core\Repositories\AbstractRepository;

class EloquentUserRepository extends AbstractRepository implements Repository, Paginable, UserRepository {

    use CrudableTrait;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * Construct
     *
     * @param \Acme\Users\Model|\Illuminate\Database\Eloquent\Model $model
     * @internal param \Illuminate\Database\Eloquent\Model $user
     */
    public function __construct(Model $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
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