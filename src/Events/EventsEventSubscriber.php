<?php namespace Acme\Events ;

class EventsEventSubscriber {

    public function subscribe($events)
    {
        $events->listen('user.*', 'Kuwaitii\Users\Events\UserEventHandler');
    }

}
