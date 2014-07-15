<?php namespace Acme\Subscription\State;

use Acme\Event\EventRepository;
use Acme\Subscription\SubscriptionRepository;
use Subscription;

class Subscriber {

    public $confirmed;
    public $approved;
    public $waiting;
    public $rejected;
    public $pending;
    public $repository;

    public $subscriptionState;

    public function __construct($status = '')
    {
        $status           = strtolower($status);
        $this->confirmed  = new Confirmed($this);
        $this->waiting    = new Waiting($this);
        $this->rejected   = new Rejected($this);
        $this->pending    = new Pending($this);
        $this->approved   = new Approved($this);
        $this->repository = new SubscriptionRepository(new Subscription);

        if ( empty($status) ) {
            $this->subscriptionState = $this->pending;
        } else {
            $this->subscriptionState = $this->{$status};
        }
    }

    public function setSubscriptionState(StateInterface $newSubscriptionState)
    {
        $this->subscriptionState = $newSubscriptionState;
    }

    public function subscribe($userId, $eventId, $eventType)
    {
        $this->subscriptionState->subscribe($userId, $eventId, $eventType);
    }

    public function unsubscribe($id)
    {
        $this->subscriptionState->unsubscribe($id);
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