<?php
namespace Acme\Subscription\State;

class Confirmed implements SubscriberState{

    protected $paymentType;
    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber  = $subscriber;
    }
    /**
     * @param $userId
     * @param $eventId
     * @param $eventType
     * @return mixed
     */
    public function subscribe($userId, $eventId, $eventType)
    {
        dd($this->subscriber->repository->findById($eventId));
    }

    public function unsubscribe($id)
    {
        echo 'unsubscribed';
    }
}