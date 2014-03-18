<?php namespace Acme\Mail;
use Mail;

/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 2/14/14
 * Time: 3:51 PM
 */

abstract class Mailer {
    public function sendTo($email, $subject, $view, $data =[]) {
//            die($email);
//          foreach($emails as $email) {
        Mail::send($view, $data, function($message) use ($email, $subject) {
            $message->to($email)
                    ->subject($subject);
        });
              echo 'Email Sent to ' . $email . ' with Subject ' . $subject .' With View ' .$view .'<br>';
//          }
    }
} 