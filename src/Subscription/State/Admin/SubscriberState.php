<?php  namespace Acme\Subscription\State\Admin;

interface SubscriberState {

    public function createSubscription();

    public function cancelSubscription();

} 