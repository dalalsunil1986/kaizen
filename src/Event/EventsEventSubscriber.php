<?php namespace Acme\Event ;

class EventsEventSubscriber {

    public function subscribe($events)
    {
        $events->listen('user.*', 'Kuwaitii\Users\Events\UserEventHandler');
    }

}
