<?php
/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 5/2/14
 * Time: 3:28 AM
 */

namespace Acme\Repo\Statuses;


class Pending extends Status implements StatusInterface {
    public function __construct() {
        parent::__construct();
    }
    public function setAction($event, $user, $status)
    {
        $status->status = 'PENDING';
        if( $status->save()) {
            $event->subscriptions()->detach($user);
            $event->updateSeats();
            $args['subject'] = 'Kaizen Event Subscription';
            $args['body'] = 'You have been put on pending list for the event ' . $event->title.'';
            return ($this->mailer->sendMail($user, $args)) ? 'done' : 'not done';
        }
    }
}