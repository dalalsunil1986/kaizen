<?php namespace Acme\Repo\Statuses;

use Lang;

class Confirmed extends Status implements StatusInterface {
    public function __construct() {
        parent::__construct($this->event,$this->user,$this->status);
    }

    public function setStatus($event, $user, $status)
    {
        if ($user->isSubscribed($event->id,$user->id)) {
            return Lang::get('site.subscription.already_subscribed', array('attribute'=>'subscribed'));
        }
        if($event->available_seats >= 1) {
            $status->status = 'CONFIRMED';
            if ($status->save()) {
                $event->subscriptions()->attach($user);
                $event->updateAvailableSeats($event);
                $args['subject'] = 'Kaizen Event Subscription';
                $args['body'] = 'You have been confirmed to the event ' . $event->title;
                $this->mailer->sendMail($user, $args);
                return Lang::get('site.subscription.subscribed', array('attribute'=>'subscribed'));
            } else {
                $this->approved($event, $user, $status);
                return 'could not subscribe';
            }
        } else {
            return Lang::get('site.subscription.no_seats_available');
        }
        return $this->approved($event, $user, $status);
    }
}