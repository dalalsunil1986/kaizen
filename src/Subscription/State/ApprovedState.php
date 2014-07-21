<?php
namespace Acme\Subscription\State;

class ApprovedState extends AbstractState implements SubscriberState {

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {

        if ( ! $this->subscriber->model->hasAvailableSeats() ) {
            // If No Seats Available, Set user status to Waiting List
            return $this->subscriber->setSubscriptionState($this->subscriber->getWaitingState());
        }

        // @todo : more efficient way to determine the free or paid event
        if ( $this->subscriber->model->subscribable->price > 0 ) {
            // Paid Event
            return $this->sendPaymentLink();
        } else {
            // Free Event
            return $this->confirmSubscription();
        }

    }

    private function confirmSubscription()
    {
        $this->subscriber->model->status = 'CONFIRMED';
        $this->subscriber->model->save();
        echo 'subscription confirmed';
    }

    private function sendPaymentLink()
    {
        //@todo Send Payment Link
        $this->subscriber->messages->add('success', 'Payment Email Sent');
    }
}