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
        if ( ! $this->subscriber->model->subscribable->hasAvailableSeats() ) {
            // If No Seats Available, Set user status to Waiting List
            return $this->subscriber->setSubscriptionState($this->subscriber->getWaitingState());
        }

        $this->checkIfValidRegistrationType();

        // Find Event Type
        if ($this->subscriber->model->subscribable->settings->settingable_type == 'EventModel') {
            dd('this is an event');
        } elseif($this->subscriber->model->subscribable->settings->settingable_type == 'Package') {
            dd('this is package');
        }
        dd($this->subscriber->model->subscribable->settings->toArray());



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

    /**
     * Check If the User Registration Type is in the available option of the Event's Registration System
     */
    private function checkIfValidRegistrationType()
    {
        $available_registration_types = $this->subscriber->model->subscribable->settings->registration_type;
        $available_registration_types = explode(',',$available_registration_types);

        if(!in_array($this->subscriber->model->registration_type,$available_registration_types)) {
            dd('option not available');
        } else {
            dd('option available');
        }
    }


}