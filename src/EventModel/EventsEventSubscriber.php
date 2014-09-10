<?php namespace Acme\EventModel ;

class EventsEventSubscriber {

    public function subscribe($events)
    {
        $events->listen('user.*', 'Kuwaitii\Users\Events\UserEventHandler');
    }

}
