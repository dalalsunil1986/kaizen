<?php namespace Acme\Subscription;

use Acme\Core\CrudableTrait;
use Acme\Core\Repositories\AbstractRepository;
use Acme\Core\Repositories\Illuminate;
use DB;
use Subscription;

class SubscriptionRepository extends AbstractRepository {

    use CrudableTrait;

    public $model;

    public function __construct(Subscription $model)
    {
        $this->model = $model;
    }

    public function registrationType()
    {
        return $this->registrationType;
    }

    public function findByEvent($userId, $eventId, $eventType)
    {
        $record = $this->model->where('user_id', $userId)->where('subscribable_id', $eventId)->where('subscribable_type', $eventType)->first();
        if ( ! $record ) return false;

        return $record;
    }

    /**
     * @param $subscribableId
     * @param $subscribableType
     * @return mixed
     * Count no of subscriptions for an Event
     */
    public function countAll($subscribableId, $subscribableType)
    {
        return $this->model->where('subscribable_id', $subscribableId)
            ->where('subscribable_type', $subscribableType)
            ->get([
                DB::raw('COUNT(id) as subscription_count')
            ]);
    }

}