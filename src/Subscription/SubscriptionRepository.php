<?php namespace Acme\Subscription;

use Acme\Core\CrudableTrait;
use Acme\Core\Repositories\AbstractRepository;
use Acme\Core\Repositories\Illuminate;
use DB;
use Subscription;

class SubscriptionRepository extends AbstractRepository {

    use CrudableTrait;

    public $model;

    public $subscriptionStatuses = ['REJECTED', 'PENDING', 'APPROVED', 'CONFIRMED'];

    public function __construct(Subscription $model)
    {
        $this->model = $model;
    }

    public function registrationType()
    {
        return $this->registrationType;
    }

    public function findByEvent($userId, $eventId)
    {
        $record = $this->model->where('user_id', $userId)->where('event_id', $eventId)->first();
        if ( ! $record ) return false;

        return $record;
    }

    /**
     * @param $eventId
     * @internal param $subscribableId
     * @return mixed
     * Count no of subscriptions for an Event
     */
    public function countAll($eventId)
    {
        return $this->model->where('event_id', $eventId)
            ->get([
                DB::raw('COUNT(id) as subscription_count')
            ]);
    }

}