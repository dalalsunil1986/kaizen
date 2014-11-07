<?php namespace Acme\Core\Mailers;

use Config;
use Illuminate\Mail\Mailer;

class AbstractMailer implements MailerInterface {

    protected $mailer;
    protected $senderEmail;
    protected $senderName;
    protected $recepientEmail;
    protected $recepientName;
    protected $subject;
    protected $view;

    public function __construct(Mailer $mailer)
    {
        $this->mailer      = $mailer;
        $this->senderEmail = Config::get('mail.from.address');
        $this->senderName  = Config::get('mail.from.name');
        $this->view        = 'emails.default';
    }

    public function fire(array $array)
    {
        try {
            $this->mailer->queue($this->view, $array, function ($message) {
                $message
                    ->from($this->senderEmail, $this->senderName)
                    ->sender($this->senderEmail, $this->senderName)
                    ->to($this->recepientEmail, $this->recepientName)
                    ->subject($this->subject);
            });

        }
        catch ( \Exception $e ) {
        }
    }
}