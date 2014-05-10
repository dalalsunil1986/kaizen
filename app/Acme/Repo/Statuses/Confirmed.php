<?php namespace Acme\Repo\Statuses;

use Lang;

class Confirmed extends Status implements StatusInterface {

    public function __construct() {
        parent::__construct();
    }
    public function setAction($event, $user, $status,$reason)
    {
        if ($user->isSubscribed($event->id,$user->id)) {
            return Lang::get('site.subscription.already_subscribed', array('attribute'=>'subscribed'));
        }
        if($event->available_seats >= 1) {
            $status->status = 'CONFIRMED';
            if ($status->save()) {
                $event->subscriptions()->attach($user);
                $event->updateSeats();
                $args['subject'] = 'Kaizen Event Subscription';
                $args['body'] = 'You have been confirmed to the event ' . $event->title;
                if(!empty($reason)) {
                    $args['body'] = $reason;
                } else {
                    $args['body'] = 'You have been confirmed to the event ' . $event->title;
                }
                $this->mailer->sendMail($user, $args);
                return Lang::get('site.subscription.subscribed', array('attribute'=>'subscribed'));
            } else {
                return $this->create(new Approved())->setStatus($event,$user,$status,$reason);
                return 'could not subscribe';
            }
        } else {
            return $this->create(new Approved())->setStatus($event,$user,$status);
            return Lang::get('site.subscription.no_seats_available');
        }

    }
}