<?php

use Acme\Mail\SubscriptionMailer;

class SubscriptionsController extends BaseController {
    protected $model;
    protected $user;
    protected $mailer;
    protected $category;
    protected $status;

    function __construct(Subscription $model, User $user, EventModel $event, User $user, Status $status, SubscriptionMailer  $mailer )
    {
        $this->model = $model;
        $this->user = $user;
        $this->event = $event;
        $this->status = $status;
        $this->mailer = $mailer;
        parent::__construct();
    }

    /**
     * @param $id eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe($id)
    {

    }

    public function unsubscribe($id)
    {

    }

}

