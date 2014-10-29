<?php namespace Acme\Subscription\State\Admin;

use Event;
use Illuminate\Support\MessageBag;
use Subscription;

class Subscriber {

    public $confirmed;
    public $approved;
    public $waiting;
    public $rejected;
    public $pending;
    public $payment;
    public $model;

    public $subscriptionState;

    public $messages;
    private $reason;

    public function __construct(Subscription $subscription, $status, $reason)
    {
        $this->confirmed = new ConfirmedState($this);
        $this->waiting   = new WaitingState($this);
        $this->rejected  = new RejectedState($this);
        $this->pending   = new PendingState($this);
        $this->approved  = new ApprovedState($this);
        $this->payment  = new PaymentState($this);
        $this->messages  = new MessageBag();
        $this->model = $subscription;
        $status                  = strtolower($status);
        $this->subscriptionState = $this->{$status};
        $this->reason = $reason;
    }

    public function setSubscriptionState($newSubscriptionState)
    {
        $this->subscriptionState = $newSubscriptionState;
        $this->subscribe();
    }

    public function subscribe()
    {
        $this->subscriptionState->createSubscription();
        // Pass the User and Event Model, and Merge both into one array and pass it to the Event Fired
        $this->notify();
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

    /**
     * @return \Acme\Subscription\State\Pending
     */
    public function getPaymentState()
    {
        return $this->payment;
    }

    /**
     * Send a Notification Email to the User
     */
    public function notify()
    {
        $user  = $this->model->user->toArray();
        $event = $this->model->event;
        $token = $this->messages->has('token') ? $this->messages->get('token') : '';
        // Merge User and Event Model
        $array = array_merge($user, ['event_id' => $event->id, 'title' => $event->title, 'status' => $this->model->status, 'token' => array_shift($token)]);
        // Fire the Event ( this will also send email to the user )
        Event::fire('subscriptions.created', [$array]);
    }
}