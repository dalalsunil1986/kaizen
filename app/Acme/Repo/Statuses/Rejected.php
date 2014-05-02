<?php
/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 5/2/14
 * Time: 3:28 AM
 */

namespace Acme\Repo\Statuses;


class Rejected extends Status implements StatusInterface {
    public function __construct() {
        parent::__construct();
    }
    public function setAction($event, $user, $status)
    {
        $status->status = 'REJECTED';
        if( $status->save()) {
            $event->subscriptions()->detach($user);
            $event->updateAvailableSeats($event);
            $args['subject'] = 'Kaizen Event Subscription';
            $args['body'] = 'Your Request have been rejected for the event ' . $event->title;
            return ($this->mailer->sendMail($user, $args)) ? 'done' : 'not done';
        }
    }
}