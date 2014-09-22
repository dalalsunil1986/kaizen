<?php

use Acme\EventModel\EventRepository;
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
     * @var Acme\EventModel\EventRepository
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

    /**
     * @param string $eventId
     * @param string $registrationType
     * @throws \Acme\Core\Exceptions\EntityNotFoundException
     * @return \Illuminate\Http\RedirectResponse
     * Accessed through post form request
     */
    public function subscribe($eventId='',$registrationType = '')
    {
        // todo : check if event is not expired

        $eventId          = empty($eventId)? Input::get('event_id'): $eventId;
        $registrationType = empty($registrationType)? Input::get('registration_type') : $registrationType;
        $userId           = Auth::user()->getAuthIdentifier();
        $subscription     = $this->subscriptionRepository->findByEvent($userId, $eventId);

        $event = $this->eventRepository->findById($eventId);

        if( !$event ) {

            return Redirect::action('EventsController@show',$eventId)->with('warning',trans('site.general.system-error'));
        }

        if( $this->eventRepository->ifOngoingEvent($event) ) {

            return Redirect::action('EventsController@show',$eventId)->with('warning',trans('site.event.event-expired'));
        }

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
        return Redirect::action('EventsController@getSuggestedEvents', $eventId)->with('success', Lang::get('site.general.check-email'));
    }

    /**
     * @param $eventId EventID
     * @return \Illuminate\Http\RedirectResponse
     * Unsubscribe a user
     */
    public function unsubscribe($eventId)
    {
        $userId       = Auth::user()->id;
        $subscription = $this->subscriptionRepository->findByEvent($userId, $eventId);

        if ( $subscription ) {
            $subscription = new Subscriber($subscription);
            $subscription->unsubscribe();

            return Redirect::home()->with('success', Lang::get('messages.subscription-unsubscripe-message'));
        }

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

    /**
     * @param $eventId
     * Confirm the Subscription after click email link
     */
    public function confirmSubscription($eventId)
    {
        $subscription     = $this->subscriptionRepository->findByEvent(Auth::user()->id, $eventId);
        if($this->subscribe($eventId,$subscription->registration_type)) {
            return Redirect::action('EventsController@getSuggestedEvents', $eventId)->with('success', Lang::get('site.general.check-email'));
        }
    }
}

