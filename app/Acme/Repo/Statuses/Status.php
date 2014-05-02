<?php namespace Acme\Repo\Statuses;

use Acme\Mail\SubscriptionMailer;
use AdminBaseController;

abstract class Status extends AdminBaseController{
    protected $mailer;

    public function __construct() {
        $this->mailer = new SubscriptionMailer();
    }

}