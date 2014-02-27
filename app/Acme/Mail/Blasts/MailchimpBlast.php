<?php namespace Acme\Mail\Blasts;

use Mailchimp;

class MailchimpBlast implements EmailBlastInterface {

    /**
     * @var Mailchimp
     */
    private $mailchimp;

    /**
     * Constructor
     *
     * @param Mailchimp $mailchimp
     */
    public function __construct(Mailchimp $mailchimp)
    {
        $this->mailchimp = $mailchimp;
    }

    /**
     * Send email blast with Mailchimp
     *
     * @param $type
     * @param $options
     * @param $content
     *
     * @return mixed|void
     */
    public function send($type, $options, $content)
    {
        $campaign = $this->mailchimp->campaigns->create($type, $options, $content);

        $this->mailchimp->campaigns->send($campaign['id']);
    }

    public function subscribe($id, $email)
    {
//        $_params = array("id" => $id, "email" => $email, "merge_vars" => $merge_vars, "email_type" => $email_type, "double_optin" => $double_optin, "update_existing" => $update_existing, "replace_interests" => $replace_interests, "send_welcome" => $send_welcome);
//        return $this->master->call('lists/subscribe', $_params);
        $this->mailchimp->lists->subscribe($id,$email);
    }
}