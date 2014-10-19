<?php namespace Acme\Subscription\State\Admin;

class ApprovedState extends AbstractState implements SubscriberState {

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        if ( ! $this->subscriber->model->event->hasAvailableSeats() ) {
            // If No Seats Available, Set user status to Waiting List
            return $this->subscriber->setSubscriptionState($this->subscriber->getWaitingState());
        }

        // check whether already subscribed
    //        if ( $this->subscriber->model->subscriptionConfirmed() ) {
    //            $this->subscriber->messages->add('errors', 'Already Subscribed');
    //            return false;
    //        }
//        dd($free  = $this->subscriber->model->event->isFreeEvent() );

        if ( $this->subscriber->model->event->isFreeEvent() ) {

            // Free Event
            return $this->subscriber->setSubscriptionState($this->subscriber->getConfirmedState());
        } else {
            // Paid Event
            return $this->subscriber->setSubscriptionState($this->subscriber->getPaymentState());
        }

    }


}