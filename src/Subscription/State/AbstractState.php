<?php
namespace Acme\Subscription\State;

class AbstractState {

    public function cancelSubscription()
    {
        $this->subscriber->model->delete();
    }

} 