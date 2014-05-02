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

class Status extends AdminBaseController{

    /**
     * @var StatusInterface
     */
    private   $repo;
    protected $event;
    protected $user;
    protected $status;
    protected $mailer;

    public function __construct($event,$user,$status) {
        $this->event = $event;
        $this->user = $user;
        $this->status = $status;
        $this->mailer = new SubscriptionMailer();
    }

    public function create(StatusInterface $repo)
    {
        $this->repo = $repo;
        return $this;
    }

    public function setStatus() {
        return $this->repo->setStatus($this->event,$this->user,$this->status);
    }
}