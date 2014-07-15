<?php  namespace Acme\Subscription\State;

interface SubscriberState {

    /**
     * @param $userId
     * @param $eventId
     * @param $eventType
     * @return mixed
     */
    public function subscribe($userId,$eventId,$eventType);

    public function unsubscribe($id);

} 