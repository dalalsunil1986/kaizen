<?php
/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 5/2/14
 * Time: 3:28 AM
 */

namespace Acme\Repo\Statuses;


use Lang;
use Response;

class Confirmed extends Status implements StatusInterface {
    protected  $model;
    public function __construct() {
        parent::__construct($this->event,$this->user,$this->status);
        $this->model = new \Subscription();
    }

    public function setStatus($event, $user, $status)
    {
        if ($this->model->isSubscribed($event->id,$user->id)) {
            // return you are already subscribed to this event
            return Response::json(array(
                'success' => false,
                'message'=> Lang::get('site.subscription.already_subscribed', array('attribute'=>'subscribed'))
            ), 400 );
        }
        if($event->available_seats >= 1) {
            $status->status = 'CONFIRMED';
            if($status->save()) {
                $event->subscriptions()->attach($user);
                $event->updateAvailableSeats($event);
                $args['subject'] = 'Kaizen Event Subscription';
                $args['body'] = 'You have been confirmed to the event ' . $event->title;
                $this->mailer->sendMail($user, $args);
                return Response::json(array(
                    'success' => true,
                    'message'=>  Lang::get('site.subscription.subscribed', array('attribute'=>'subscribed'))
                ), 200);
            } else {
                return Response::json(array(
                    'success' => false,
                    'message' => 'could not subscribe'
                ), 200);
                return $this->approved($event, $user, $status);
                //@todo reset status
            }
        } else {
            return Response::json(array(
                'success' => false,
                'message'=> Lang::get('site.subscription.no_seats_available')
            ), 400);
        }
        return $this->approved($event, $user, $status);
    }
}