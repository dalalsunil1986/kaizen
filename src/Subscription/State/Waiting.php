<?php
namespace Acme\Subscription\State;

class Waiting implements SubscriberState{

    /**
     * @param $userId
     * @param $eventId
     * @param $eventType
     * @return mixed
     */
    public function subscribe($userId, $eventId, $eventType)
    {
        echo 'event seats full';
    }

    public function unsubscribe($id)
    {
        echo 'not subscribed at first place ';
    }
}