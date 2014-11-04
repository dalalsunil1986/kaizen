<?php
namespace Acme\Subscription\State;

class AbstractState {

    public function cancelSubscription()
    {
        $this->subscriber->setSubscriptionState($this->subscriber->getCancelledState());
        return $this;
    }

} 