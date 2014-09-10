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
//        if ( $this->subscriber->model->settings[0]->settingable_type == 'Package' ) {
//            // find if the user already subscribed any sub events as individual
//            // find all sub events for the package
//            // check whether any event_id that matches the user id is in the subscriptions
//            dd('this is package');
//
//        }
//        dd('this is event');

        // check whether already subscribed
        if ( $this->subscriber->model->subscriptionConfirmed() ) {
            $this->subscriber->messages->add('errors', 'Already Subscribed');
            return false;
        }

//        $this->checkValidRegistrationType();
        // Find Event Type

//        if ( $this->subscriber->model->settings[0]->settingable_type == 'EventModel' ) {
//            dd('this is an event');
//        } elseif ( $this->subscriber->model->settings[0]->settingable_type == 'Package' ) {
//            dd('this is package');
//        }

//        dd($this->subscriber->model->settings[0]->toArray());

        // @todo : more efficient way to determine the free or paid event
        // change this to 1 ..

        $this->subscriber->model->status = 'APPROVED';
        $this->subscriber->model->save();

        if ( $this->subscriber->model->event->free == 1 ) {
            // Paid Event
            return $this->sendPaymentLink();
        } else {
            // Free Event
            return $this->subscriber->setSubscriptionState($this->subscriber->getConfirmedState());
        }

    }

    private function sendPaymentLink()
    {
        //@todo Send Payment Link

        $this->subscriber->messages->add('success', 'Payment Email Sent');
    }

    /**
     * Check If the User Registration Type is in the available option of the Event's Registration System
     */
    private function checkValidRegistrationType()
    {
        $available_registration_types = $this->subscriber->model->settings[0]->registration_types;
        $available_registration_types = explode(',', $available_registration_types);
        if ( ! in_array($this->subscriber->model->registration_type, $available_registration_types) ) {
            $this->subscriber->messages->add('errors', 'Option not available');

            return false;
        }
    }


}