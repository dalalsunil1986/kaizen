<?php

use Acme\Event\EventRepository;
use Acme\Subscription\State\Subscriber;
use Acme\Subscription\SubscriptionRepository;

class SubscriptionsController extends BaseController {

    /**
     * @var Acme\Subscription\SubscriptionRepository
     */
    protected $subscriptionRepository;
    /**
     * @var Acme\Subscription\State\Subscriber
     */
    private $subscriber;
    /**
     * @var Acme\Event\EventRepository
     */
    private $eventRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository, EventRepository $eventRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        parent::__construct();
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param $userId
     * @param $eventId
     * @param $eventType
     */
    public function subscribe($userId = 2, $eventId = 4, $eventType = 'Package')
    {
        $subscription = $this->subscriptionRepository->findByEvent($userId, $eventId, $eventType);
        $event = $this->eventRepository->findById($eventId);

        if ( ! $subscription ) {
            $subscription = $this->subscriptionRepository->create(['user_id' => $userId, 'subscribable_id' => $eventId, 'subscribable_type' => $eventType, 'status' => '', 'registration_type' => 'VIP']);
        }

        $subscription = new Subscriber($subscription,$event);
        $subscription->subscribe();
        dd('subscribed');

    }

    /**
     * @param $id
     */
    public function unsubscribe($id)
    {
        $event        = $this->subscriptionRepository->findById($id);
        $subscription = new Subscriber($event);
        $subscription->unsubscribe();
        dd('unsubscribed');
    }

    /**
     * @param $subscriptionId
     */
    public function makePayment($subscriptionId)
    {
        // process payment
    }

}

