<?php
namespace Acme\Subscription\State;

class ApprovedState implements StateInterface{

    /**
     * @param $id == ID of Event of Package
     * @param $type = Event or Package
     * @return mixed
     */
    public function subscribe($id, $type)
    {
        // TODO: Implement subscribe() method.
        // if event seats full set Waiting State
        // set Confirm State
    }

    public function unsubscribe($id, $type)
    {
        // TODO: Implement unsubscribe() method.
        // delete entry from db
    }
}