<?php
/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 2/27/14
 * Time: 6:57 PM
 */

class NewslettersController extends BaseController{


    public function __contstruct() {
        parent::__construct();
    }

    /**
     * @internal param array $email Add a user to the newsletter list* Add a user to the newsletter list
     * @return \Illuminate\Http\RedirectResponse
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

} 