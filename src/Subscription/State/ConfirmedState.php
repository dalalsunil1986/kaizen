<?php
namespace Acme\Subscription\State;

use Auth;

class ConfirmedState extends AbstractState implements SubscriberState {

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        $this->subscriber->model->status = 'CONFIRMED';
        $this->subscriber->model->save();

        // update available seats .. find the function in EventModel
        $this->subscriber->model->event->decrementAvailableSeats();
    }

    public function cancelSubscription()
    {
        // If paid event. If user has made payment
        if ( !$this->subscriber->model->event->isFreeEvent() ) {

            if ( $payment = $this->subscriber->model->paymentSuccess ) {
                // make the refund value
                $payment->status = 'CANCELLED'; // Set the Payment Status to Cancelled
                $payment->save();

                // Create a Refund
                $payment->refunds()->create(['user_id' => Auth::user()->id, 'status' => 'PENDING']);
            }

        }

        $this->subscriber->model->delete();

        // update available seats .. find the function in EventModel
        $this->subscriber->model->event->incrementAvailableSeats();
    }

}