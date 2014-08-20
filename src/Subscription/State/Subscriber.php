<?php namespace Acme\Subscription\State;

use Illuminate\Support\MessageBag;
use Subscription;

class Subscriber {

    public $confirmed;
    public $approved;
    public $waiting;
    public $rejected;
    public $pending;
    public $model;

    public $subscriptionState;

    public $messages;

    public function __construct(Subscription $subscription)
    {
        $this->confirmed = new ConfirmedState($this);
        $this->waiting   = new WaitingState($this);
        $this->rejected  = new RejectedState($this);
        $this->pending   = new PendingState($this);
        $this->messages  = new MessageBag();
        $this->approved  = new ApprovedState($this);

        $this->model     = $subscription;

        if ( empty($this->model->status) ) {
            $this->subscriptionState = $this->pending;
            $this->messages->add('status','pending');

        } else {
            $status                  = strtolower($this->model->status);
            $this->subscriptionState = $this->{$status};
            $this->messages->add('status', $status);
        }
    }

    public function setSubscriptionState($newSubscriptionState)
    {
        $this->subscriptionState = $newSubscriptionState;
        $this->subscribe();
    }

    public function subscribe()
    {
        $this->subscriptionState->createSubscription();

    }

    public function unsubscribe()
    {
        $this->subscriptionState->cancelSubscription();
    }

    public function getConfirmedState()
    {
        return $this->confirmed;
    }

    /**
     * @return \Acme\Subscription\State\Approved
     */
    public function getApprovedState()
    {
        return $this->approved;
    }

    /**
     * @return \Acme\Subscription\State\Waiting
     */
    public function getWaitingState()
    {
        return $this->waiting;
    }

    /**
     * @return \Acme\Subscription\State\Rejected
     */
    public function getRejectedState()
    {
        return $this->rejected;
    }

    /**
     * @return \Acme\Subscription\State\Pending
     */
    public function  getPendingState()
    {
        return $this->pending;
    }

}