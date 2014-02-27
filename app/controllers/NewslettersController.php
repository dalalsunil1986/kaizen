<?php
/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 2/27/14
 * Time: 6:57 PM
 */

class NewslettersController extends BaseController{


    public function __contstruct() {
        //parent::__construct();
    }

    /**
     * @param array $email
     * Add a user to the newsletter list
     */
    public function storeNewsletter() {
        $getEmail = Input::get('email');
        $email['email'] = $getEmail;
        try {
            Notify::subscribeUser('de1f937717',$email);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
} 