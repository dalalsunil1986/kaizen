<?php
namespace Acme\Subscription\State;

class RejectedState implements StateInterface{

    /**
     * @param $id == ID of Event of Package
     * @param $type = Event or Package
     * @return mixed
     */
    public function subscribe($id, $type)
    {
        // TODO: Implement subscribe() method.
        // your request has been rejected
    }

    public function unsubscribe($id, $type)
    {
        // TODO: Implement unsubscribe() method.
        // delete entry from db
    }
}