<?php
/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 5/2/14
 * Time: 3:28 AM
 */

namespace Acme\Repo\Statuses;


class Approved extends Status implements StatusInterface{

    public function __construct() {
        parent::__construct();
    }
    public function setAction($event, $user, $status,$reason)
    {
        $type = $event->type;
        switch($type->type) {
            case 'FREE':
                // Check the Event Approval Type ( Direct or Mod )
                switch($type->approval_type) {
                    // If Direct, Whenever Admin Changes The Status To Approved Subscribe Him
                    case 'DIRECT':
                        return $this->create(new Confirmed())->setStatus($event,$user,$status,$reason);
                        break;
                    // If Mod, Whever Admin Changes The Status To Approves, Send User an Email to Subscribe
                    case 'MOD':
                        $status->status = 'APPROVED';
                        if( $status->save()) {
                            $event->subscriptions()->detach($user);
                            $event->updateSeats();
                            $args['subject'] = 'Kaizen Event Subscription';
                            if(!empty($reason)) {
                                $args['body'] = $reason;
                            } else {
                                $args['body'] = 'You have been approved for the event ' . $event->title. '. Please '. link_to_action('SubscriptionsController@subscribe', 'Click Here', $event->id).' to confirm the subscriptions';
                            }
                            return ($this->mailer->sendMail($user, $args)) ? 'done' : 'not done';
                        }
                        break;
                }
                break;
            // if event is a paid event
            case 'PAID':
                break;
            default:
                break;
        }
    }
}