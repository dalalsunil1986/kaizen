<?php namespace Acme\Subscription\State;

use Subscription;

class Subscriber {

    public $confirmed;
    public $approved;
    public $waiting;
    public $rejected;
    public $pending;
    public $repository;

    public $subscriptionState;

    public function __construct(Subscription $subscription, EventModel $eventModel)
    {
        $this->confirmed  = new ConfirmedState($this);
        $this->waiting    = new WaitingState($this);
        $this->rejected   = new RejectedState($this);
        $this->pending    = new PendingState($this);
        $this->approved   = new ApprovedState($this);
        $this->repository = $subscription;

        if ( empty($this->repository->status) ) {
            $this->subscriptionState = $this->pending;
        } else {
            $status                  = strtolower($this->repository->status);
            $this->subscriptionState = $this->{$status};
        }

    }

    public function setSubscriptionState($newSubscriptionState)
    {
        $this->subscriptionState = $newSubscriptionState;
    }

    public function subscribe()
    {
//        if ( ! $this->subscriptionState == $this->repository->status ) {
            $this->subscriptionState->createSubscription();
//        }
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
    public function getPendingState()
    {
        return $this->pending;
    }

}