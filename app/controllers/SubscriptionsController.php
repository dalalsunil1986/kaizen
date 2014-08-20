<?php

use Acme\Event\EventRepository;
use Acme\Package\PackageRepository;
use Acme\Subscription\State\Subscriber;
use Acme\Subscription\SubscriptionRepository;

class SubscriptionsController extends BaseController {

    /**
     * @var Acme\Subscription\SubscriptionRepository
     */
    private $subscriptionRepository;
    /**
     * @var Acme\Subscription\State\Subscriber
     */
    private $subscriber;
    /**
     * @var Acme\Event\EventRepository
     */
    private $eventRepository;
    /**
     * @var Acme\Package\PackageRepository
     */
    private $packageRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository, EventRepository $eventRepository, PackageRepository $packageRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->eventRepository   = $eventRepository;
        $this->packageRepository = $packageRepository;
        parent::__construct();
    }

    /**
     * @param int $userId
     * @param int $eventId
     * @internal param $eventType
     * @return \Illuminate\Http\RedirectResponse
     */

    public function subscribe ($userId, $eventId) {
        $subscription = $this->subscriptionRepository->findByEvent($userId, $eventId);
        if ( ! $subscription ) {

             /*if a user is not registered why the $subscription btn is activated ? !!!!
            even though still when the subscription btn is clicked .. a success message is shown .. means there is a value for subscriptionRepostory findByEvent ? !!
             please explain this .. the user is not registered then there is no userId thank you - usama 20.8.14
             */
            $subscription = $this->subscriptionRepository->create(['user_id' => $userId, 'event_id' => $eventId, 'status' => '', 'registration_type' => 'ONLINE']);
            return Redirect::home()->with('errors', Lang::get('messages.'.$subscription->messages->toAlert().'-message'));
        }
        $subscription = new Subscriber($subscription);
        $subscription->subscribe();
        if ( $subscription->messages->has('errors') ) {
            //pending-message
            return Redirect::home()->with('errors', Lang::get('messages.'.$subscription->messages->toAlert().'-message'));
        }

        return Redirect::home()->with('success', Lang::get('messages.'.$subscription->messages->toAlert().'-message'));
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

    public function subscribePackage($userId = 1, $packageId = 1)
    {
        // loop through packages each events and subscribe
        $package = $this->packageRepository->findById($packageId);

        foreach ( $package->events as $event ) {
            $this->subscribe($userId, $event->id);
        }

    }


    /**
     * @param $subscriptionId
     */
    public function makePayment($subscriptionId)
    {
        // process payment
    }

}

