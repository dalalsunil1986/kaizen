<?php namespace Acme\Repo\Statuses;

use Lang;
use Redirect;

class Confirmed extends Status implements StatusInterface {

    public function __construct() {
        parent::__construct();
    }
    public function setAction($event, $user, $status,$reason)
    {
        if ($user->isSubscribed($event->id,$user->id)) {
            return Redirect::action('AdminStatusesController@index')->with(array('error'=>'This Person is already subscribed to this Event'));
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
                if($this->mailer->sendMail($user, $args)) {
                    return Redirect::action('AdminStatusesController@index')->with(array('success'=>'Success'));
                } else {
                    return Redirect::action('AdminStatusesController@index')->with(array('error'=>'Error please try again'));
                }
            } else {
                return $this->create(new Approved())->setStatus($event,$user,$status,$reason);
            }
        } else {
            return $this->create(new Approved())->setStatus($event,$user,$status,$reason);
        }

    }
}