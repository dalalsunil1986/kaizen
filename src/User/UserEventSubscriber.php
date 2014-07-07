<?php namespace Acme\User;

class UserEventSubscriber {

    public function subscribe($events)
    {
        $events->listen('user.*', 'Acme\Users\Events\UserEventHandler');
    }

}
