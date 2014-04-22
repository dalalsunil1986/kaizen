<?php namespace Acme\Mail;
use Mail;

/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 2/14/14
 * Time: 3:51 PM
 */

abstract class Mailer {
    /**
     * The method
     * @param $model instance of a model object with username and email
     * @param $args
     * @internal param $user
     * @return mixed
     */
    abstract function sendMail($model,$args);

    /**
     * @param $view
     * @param $args
     * @param $user
     * @return bool
     */
    public function send($view, $args,$user) {
        try {

            Mail::send($view, $args, function($message) use($args,$user){
                $message->from($args['email'],$args['name']);
                $message->sender($args['email'],$args['name'] );
                $message->to($user->email, $user->username);
                $message->subject($args['subject']);
            });
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

} 