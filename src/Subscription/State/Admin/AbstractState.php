<?php namespace Acme\Subscription\State\Admin;

class AbstractState {

    public function cancelSubscription()
    {
        $this->subscriber->model->delete();
    }

} 