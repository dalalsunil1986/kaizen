<?php

use Acme\Subscription\SubscriptionRepository;

class SubscriptionsController extends BaseController {

    /**
     * @var Acme\Subscription\SubscriptionRepository
     */
    protected $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        parent::__construct();
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * @param $userId
     * @param $eventId
     * @param $eventType
     */
    public function subscribe($userId,$eventId,$eventType)
    {

    }

    /**
     * @param $subscriptionId
     */
    public function unsubscribe($subscriptionId)
    {

    }

    /**
     * @param $subscriptionId
     */
    public function makePayment($subscriptionId)
    {
        // process payment
    }

}

