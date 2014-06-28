<?php namespace Acme\Blog;

class BlogEventSubscriber {

    public function subscribe($events)
    {
        $events->listen('user.*', 'Acme\Users\Events\UserEventHandler');
    }

}
