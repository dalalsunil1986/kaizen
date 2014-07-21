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
        // if free type directly subsribe
        // if paid .. check columns if the payment was successfull. subcribe.
        $availableSeats = $this->subscriber->repository->subscribable->available_seats;

        if ( $availableSeats <= 0 ) {
            return $this->subscriber->setSubscriptionState($this->subscriber->getWaitingState());
        }

        // @todo : more efficient way to determine the free or paid event
        if ( $this->subscriber->repository->subscribable->price > 0 ) {
            // Paid Event
            $this->sendPaymentLink();
        } else {
            // Free Event
            $this->confirmSubscription();
        }

    }

    private function confirmSubscription()
    {
        dd('confirmed');
        $this->subscriber->repository->status = 'CONFIRMED';
        $this->subscriber->repository->save();
        echo 'subscription confirmed';
    }

    private function sendPaymentLink()
    {
        //@todo Send Payment Link
        $this->subscriber->messages->add('success','Payment Email Sent');
    }
}