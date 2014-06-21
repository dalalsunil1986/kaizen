<?php namespace Acme\Users;

class UserEventSubscriber {

    public function subscribe($events)
    {
        $events->listen('user.*', 'Kuwaitii\Users\Events\UserEventHandler');
    }

}
