<?php
namespace Acme\Subscription\State;

class WaitingState implements StateInterface{

    /**
     * @param $id == ID of Event of Package
     * @param $type = Event or Package
     * @return mixed
     */
    public function subscribe($id, $type)
    {
        // TODO: Implement subscribe() method.
        // cannot subscribe
    }

    public function unsubscribe($id, $type)
    {
        // TODO: Implement unsubscribe() method.
        // delete entry from db
    }
}