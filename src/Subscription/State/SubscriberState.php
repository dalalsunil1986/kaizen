<?php  namespace Acme\Subscription\State;

interface SubscriberState {

    /**
     * @return mixed
     */
    public function createSubscription();

    public function cancelSubscription();

} 