<?php
/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 5/2/14
 * Time: 3:27 AM
 */

namespace Acme\Repo\Statuses;


use Acme\Mail\SubscriptionMailer;
use AdminBaseController;

abstract class Status extends AdminBaseController{


    protected $mailer;

    public function __construct() {
        $this->mailer = new SubscriptionMailer();
    }
}