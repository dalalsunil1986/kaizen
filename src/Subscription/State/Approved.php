<?php
namespace Acme\Subscription\State;

class Approved implements SubscriberState{

    /**
     * @param $userId
     * @param $eventId
     * @param $eventType
     * @return mixed
     */
    public function subscribe($userId, $eventId, $eventType)
    {
        // if free type directly subsribe

        // if paid .. check columns if the payment was successfull. subcribe.
        echo 'subscribed';
    }

    public function unsubscribe($id)
    {
        echo 'not subscribed at first place ';
    }
}