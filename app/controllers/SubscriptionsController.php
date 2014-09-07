<?php

use Acme\Event\EventRepository;
use Acme\Package\PackageRepository;
use Acme\Subscription\State\Subscriber;
use Acme\Subscription\SubscriptionRepository;
use Illuminate\Support\MessageBag;

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
            $subscription = $this->subscriptionRepository->create(['user_id' => $userId, 'event_id' => $eventId, 'status' => '', 'registration_type' => 'ONLINE']);
            return Redirect::home()->with('errors', Lang::get('messages.subscription-error-message'));
        }
        $status = $subscription->status;
        $subscription = new Subscriber($subscription);
        $subscription->subscribe();

        if ( $subscription->messages->has('status') ) {
            $event = $this->eventRepository->findById($eventId);
            $email = new MessageBag();
            $body = $email->emailBody('subscription',$status);
            $user = user::find($userId);
            Mail::later(1,'site.emails.subscriptions', array('id'=>$event->id,'title_en'=>$event->title_en, 'description_en'=> $event->description_en, 'body'=>$body), function($message) use ($userId, $event, $user){
                $message->to($user->email, $user->name_en )->subject('Kaizen - '.$event->title_en.' : Subscription Pending');
            });
            return Redirect::home()->with('success', Lang::get('messages.subscription-pending-message'));
        }
        return Redirect::home()->with('success', Lang::get('messages.subscription-conflict-message'));
    }

    /**
     * @param $id
     */
    public function unsubscribe($userId,$eventId)
    {
        $subscription = $this->subscriptionRepository->findByEvent($userId,$eventId);

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

    public function isSubscribed ($eventId, $userId) {
        $subscription = Subscription::whereRaw('user_id = '.$userId.' and event_id = '.$eventId.'')->count();
        return $subscription;

    }

}

