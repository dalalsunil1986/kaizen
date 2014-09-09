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

    /*
     * tagController ==> TagRepository ==>
     * */
    private $packageRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository, EventRepository $eventRepository, PackageRepository $packageRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->eventRepository        = $eventRepository;
        $this->packageRepository      = $packageRepository;
        $this->beforeFilter('auth', ['subscribe', 'unsubscribe', 'subscribePackage']);
        parent::__construct();
    }

    public function subscribeTypes()
    {
        $this->render('site.events.types');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * Accessed through post form request
     */
    public function subscribe()
    {
        $eventId          = Input::get('event_id');
        $registrationType = Input::get('registration_type');
        $userId           = Auth::user()->getAuthIdentifier();
        $subscription     = $this->subscriptionRepository->findByEvent($userId, $eventId);

        if ( !$subscription ) {
            // If no subscription entry in the database, create one
            $subscription = $this->subscriptionRepository->create(['user_id' => $userId, 'event_id' => $eventId, 'status' => '', 'registration_type' => $registrationType]);
        }

        // Subscribe the user to the event
        $subscriber = new Subscriber($subscription);
        $subscriber->subscribe();

        if ( $subscriber->messages->has('errors') ) {
            // redirect with first error as an array
            return Redirect::home()->with('errors', [$subscriber->messages->first('errors')]);
        }

        // If no errors occured while subscription process
        return Redirect::home()->with('success', Lang::get('messages.subscription-pending-message'));
    }

    /**
     * @param $userId
     * @param $eventId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unsubscribe($userId, $eventId)
    {
        $subscription = $this->subscriptionRepository->findByEvent($userId, $eventId);

        $subscription = new Subscriber($subscription);
        $subscription->unsubscribe();

        return Redirect::home()->with('success', Lang::get('messages.subscription-unsubscripe-message'));
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

