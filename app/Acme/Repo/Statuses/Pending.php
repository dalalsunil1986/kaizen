<?php
/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 5/2/14
 * Time: 3:28 AM
 */

namespace Acme\Repo\Statuses;


use Redirect;

class Pending extends Status implements StatusInterface {
    public function __construct() {
        parent::__construct();
    }


    public function setAction($event, $user, $status,$reason)
    {
        $status->status = 'PENDING';
        if( $status->save()) {
            $event->subscriptions()->detach($user);
            $event->updateSeats();
            $args['subject'] = 'Kaizen Event Subscription';
            if(!empty($reason)) {
                $args['body'] = $reason;
            } else {
                $args['body'] = 'You have been put on pending list for the event ' . $event->title.'';
            }
            if($this->mailer->sendMail($user, $args)) {
                return Redirect::action('AdminStatusesController@index')->with(array('success'=>'Success'));
            } else {
                return Redirect::action('AdminStatusesController@index')->with(array('error'=>'Error please try again'));
            }
        }
    }
}