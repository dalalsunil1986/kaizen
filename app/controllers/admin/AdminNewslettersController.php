<?php
/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 2/27/14
 * Time: 6:57 PM
 */

class NewslettersController extends AdminBaseController{


    public function __contstruct() {
        parent::__construct();
    }

    /**
     * @param array $email
     * Add a user to the newsletter list
     */
    public function store() {
        $getEmail = Input::get('email');
        $email['email'] = $getEmail;
        try {
            Notify::subscribeUser('de1f937717',$email);
            return Redirect::home()->with(array('message'=>'You have been subscribed'));
        } catch (\Exception $e) {
            return Redirect::home()->withErrors($e->getMessage());
        }
    }

    public function send($data) {
        //@todo
        //send newsletter emai
        Notify::newsletterSubscribers($data);
    }
} 