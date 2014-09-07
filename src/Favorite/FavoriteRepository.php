<?php namespace Acme\Favorite;

use Acme\Core\CrudableTrait;
use Acme\Core\Repositories\Illuminate;
use Acme\Core\Repositories\AbstractRepository;
use Favorite;

class FavoriteRepository extends AbstractRepository {

    public $model;

    public function __construct(Favorite $model)
    {
        $this->model = $model;
    }

    /**
     * @param $eventId eventId
     * @param $userId
     * @return boolean
     */
    public function hasFavorited($eventId,$userId) {
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
    public function unfavorite($eventId,$userId) {
        $query = $this->model->where('user_id','=',$userId)->where('event_id','=',$eventId)->delete();
        return $query ? true : false;
    }

}