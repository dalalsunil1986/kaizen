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
        if ( ! $this->subscriber->model->event->hasAvailableSeats() ) {
            // If No Seats Available, Set user status to Waiting List
            return $this->subscriber->setSubscriptionState($this->subscriber->getWaitingState());
        }

        // If its a package event
//        if ( $this->subscriber->model->settings[0]->settingable_type == 'Package' ) {
//        }

        // check whether already subscribed
        if ( $this->subscriber->model->subscriptionConfirmed()) {
            $this->subscriber->messages->add('errors','Already Subscribed');
            return false;
        }

        $this->checkInvalidRegistrationType();
        // Find Event Type

//        if ( $this->subscriber->model->settings[0]->settingable_type == 'EventModel' ) {
//            dd('this is an event');
//        } elseif ( $this->subscriber->model->settings[0]->settingable_type == 'Package' ) {
//            dd('this is package');
//        }

//        dd($this->subscriber->model->settings[0]->toArray());

        // @todo : more efficient way to determine the free or paid event
        if ( $this->subscriber->model->event->price > 0 ) {
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

    /**
     * Check If the User Registration Type is in the available option of the Event's Registration System
     */
    private function checkInvalidRegistrationType()
    {
        $available_registration_types = $this->subscriber->model->settings[0]->registration_types;
        $available_registration_types = explode(',', $available_registration_types);
        if ( ! in_array($this->subscriber->model->registration_type, $available_registration_types) ) {
            $this->subscriber->messages->add('errors','Option not available');
            return false;
        }
    }


}