<?php
namespace Acme\Subscription\State;

class Pending implements SubscriberState{


    /**
     * @param $userId
     * @param $eventId
     * @param $eventType
     * @return mixed
     */
    public function subscribe($userId, $eventId, $eventType)
    {
        echo 'waiting for admin approval';
    }

    public function unsubscribe($id)
    {
        echo 'not subscribed at first place ';
    }
}