<?php
namespace Acme\Subscription\State;

class PendingState implements StateInterface{

    /**
     * @param $id == ID of Event of Package
     * @param $type = Event or Package
     * @return mixed
     */
    public function subscribe($id, $type)
    {
        // TODO: Implement subscribe() method.
        // waiting for admin approval
    }

    public function unsubscribe($id, $type)
    {
        // TODO: Implement unsubscribe() method.
        // delete entry from db
    }
}