<?php
use Acme\Core\Mailers\Bulk\MailchimpMailer;

class NewslettersController extends BaseController{

protected $bulkMailer;


    public function __contstruct() {

        $this->bulkMailer = new MailchimpMailer(new Mailchimp('107025e4b301304e9a4e226b1668b370-us3'));

//        $getEmail = Input::get('email');
//        $email['email'] = $getEmail;
//        try {
//            Notify::subscribeUser('de1f937717',$email);
//            return Redirect::home()->with(array('message'=>'You have been subscribed'));
//        } catch (\Exception $e) {
//            return Redirect::home()->withErrors($e->getMessage());
//        }
    }

    public function index(){
        dd($this->bulkMailer);
    }

} 