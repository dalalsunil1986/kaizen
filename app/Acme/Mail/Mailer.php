<?php namespace Acme\Mail;
use Mail;

/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 2/14/14
 * Time: 3:51 PM
 */

abstract class Mailer {
    public function send($email, $subject, $view, $data) {
        Mail::send($view, $data, function($message) use ($email, $subject) {
            $message->to($email)
                    ->subject($subject);
        });
    }

    /**
     * @param $model
     * @param $args
     * @internal param $user
     * @return mixed
     */
    abstract function sendMail($model,$args);

    public function sendTo($view, $args,$user) {
        Mail::send($view, $args, function($message) use($args,$user){
            $message->from($args['email'],$args['name']);
            $message->sender($args['email'],$args['name'] );
            $message->to($user->email, $user->username);
            $message->subject($args['subject']);
        });
    }

} 