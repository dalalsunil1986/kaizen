<?php
namespace Acme\Subscription\State;

use Auth;

class CancelledState extends AbstractState implements SubscriberState {


    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function createSubscription()
    {
        $this->subscriber->messages->add('errors', trans('general.subscription_error'));
        return $this;
    }

    public function cancelSubscription()
    {
        $this->subscriber->model->status = 'CANCELLED';
        $this->subscriber->model->save();

        if ( !$this->subscriber->model->event->isFreeEvent() ) {

            if ( $payment = $this->subscriber->model->paymentSuccess ) {
                // make the refund value
                $payment->status = 'REFUNDING';

                $payment->save();
                // Create a Refund
                $payment->refunds()->create(['user_id' => Auth::user()->id, 'status' => 'PENDING']);
            }

        }

        // update available seats .. find the function in EventModel
        $this->subscriber->model->event->updateAvailableSeats();
        $this->subscriber->model->delete();
        return $this;
    }

}