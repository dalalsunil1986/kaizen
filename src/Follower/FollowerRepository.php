<?php namespace Acme\Follower;

use Acme\Core\CrudableTrait;
use Acme\Core\Repositories\Illuminate;
use Acme\Core\Repositories\AbstractRepository;
use Follower;

class FollowerRepository extends AbstractRepository {

    public $model;

    public function __construct(Follower $model)
    {
        $this->model = $model;
    }

    /**
     * @param $eventId eventId
     * @param $userId
     * @return boolean
     */
    public function isFollowing($eventId,$userId) {
        $query = $this->model->where('user_id', '=', $userId)->where('event_id', '=', $eventId)->count();
        return ($query >= 1 ) ? true : false;
    }

    /**
     *
     * @param $eventId eventId
     * @param $userId
     * @return boolean true
     * Unfollow User
     */
    public function unfollow($eventId,$userId) {
        $query = $this->model->where('user_id','=',$userId)->where('event_id','=',$eventId)->delete();
        return $query ? true : false;
    }

}