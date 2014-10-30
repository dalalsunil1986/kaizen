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

        // If its a package event
//        if ( $this->subscriber->model->event->package ) {
//            dd('this is a package');
//        } else {
//            dd('this is not a package');
//        }

//        dd($this->subscriber->model->event->package);
//

//        dd('this is event');

        // check whether already subscribed
    //        if ( $this->subscriber->model->subscriptionConfirmed() ) {
    //            $this->subscriber->messages->add('errors', 'Already Subscribed');
    //            return false;
    //        }
//        dd($free  = $this->subscriber->model->event->isFreeEvent() );

        if ( $this->subscriber->model->event->isFreeEvent() ) {

            // Free Event
            if ( $this->subscriber->model->event->setting->approval_type == 'CONFIRM' ) {

                $this->subscriber->model->status = 'APPROVED';
                $this->subscriber->model->save();

            } else {

                return $this->subscriber->setSubscriptionState($this->subscriber->getConfirmedState());

            }
        } else {
            // Paid Event
            return $this->subscriber->setSubscriptionState($this->subscriber->getPaymentState());
        }

    }


}