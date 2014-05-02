<?php
/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 5/2/14
 * Time: 3:28 AM
 */

namespace Acme\Repo\Statuses;


class Approved extends Status implements StatusInterface {

    public function __construct() {

    }

    public function setStatus($event, $user, $status)
    {
        $status->status = 'APPROVED';
        if( $status->save()) {
            $event->subscriptions()->detach($user);
            $event->updateAvailableSeats($event);
            $args['subject'] = 'Kaizen Event Subscription';
            $args['body'] = 'You have been approved for the event ' . $event->title. '. Please '. link_to_action('SubscriptionsController@subscribe', 'Click Here', $event->id).' to confirm the subscriptions';
            return ($this->mailer->sendMail($user, $args)) ? 'done' : 'not done';
        }
    }
}