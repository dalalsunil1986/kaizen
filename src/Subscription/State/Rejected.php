<?php
namespace Acme\Subscription\State;

class Rejected implements SubscriberState{

    /**
     * @param $userId
     * @param $eventId
     * @param $eventType
     * @return mixed
     */
    public function subscribe($userId, $eventId, $eventType)
    {
        echo 'you cannot subscribe';
    }

    public function unsubscribe($id)
    {
        echo 'not subscribed at first place ';
    }
}