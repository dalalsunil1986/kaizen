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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subscribe($userId = 1, $eventId = 1, $eventType = 'EventModel')
    {
        $subscription = $this->subscriptionRepository->findByEvent($userId, $eventId, $eventType);

        dd($subscription->toArray());
        if ( ! $subscription ) {
            $subscription = $this->subscriptionRepository->create(['user_id' => $userId, 'subscribable_id' => $eventId, 'subscribable_type' => $eventType, 'status' => '', 'registration_type' => 'ONLINE']);
        }

        $subscription = new Subscriber($subscription);
        $subscription->subscribe();
        if ( $subscription->messages->has('errors') ) {
            return Redirect::home()->with('errors', $subscription->messages);
        }

        return Redirect::home()->with('success', $subscription->messages);
    }

    /**
     * @param $id
     */
    public function unsubscribe($id)
    {
        $subscription = $this->subscriptionRepository->findById($id);

        $subscription = new Subscriber($subscription);
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

