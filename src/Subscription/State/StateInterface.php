<?php  namespace Acme\Subscription\State;

interface StateInterface {

    /**
     * @param $id == ID of Event of Package
     * @param $type = Event or Package
     * @return mixed
     */
    public function subscribe($id,$type);

    public function unsubscribe($id,$type);

} 