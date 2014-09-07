<?php

use Acme\Event\EventRepository;
use Acme\Package\PackageRepository;
use Acme\Subscription\State\Admin\Subscriber;
use Acme\Subscription\SubscriptionRepository;
use Acme\User\UserRepository;
use Illuminate\Support\MessageBag;


class AdminSubscriptionsController extends AdminBaseController {

    /**
     * @var Acme\Subscription\SubscriptionRepository
     */
    private $subscriptionRepository;
    /**
     * @var Acme\Event\EventRepository
     */
    private $eventRepository;
    /**
     * @var Acme\Package\PackageRepository
     */
    private $packageRepository;
    /**
     * @var Acme\User\UserRepository
     */
    private $userRepository;

    function __construct(SubscriptionRepository $subscriptionRepository, EventRepository $eventRepository, PackageRepository $packageRepository, UserRepository $userRepository)
    {
        parent::__construct();
        $this->subscriptionRepository = $subscriptionRepository;
        $this->eventRepository        = $eventRepository;
        $this->packageRepository      = $packageRepository;
        $this->userRepository         = $userRepository;
    }

    public function index()
    {
        $status = Input::get('status');
        $type   = Input::get('type');

        if ( ! isset($type) ) {
            $type = 'event';
        } else {
            $type = Input::get('type');
        }

        if ($type == 'event') {
            if ( isset($status) ) {
                $subscriptions = $this->subscriptionRepository->getAllByStatus($status, ['user', 'event']);
            } else {
                $subscriptions = $this->subscriptionRepository->getAll(['user', 'event']);
            }
        } else {
            if ( isset($status) ) {
                $subscriptions = $this->packageRepository->getAll(['user', 'event']);
            } else {
                $subscriptions = $this->packageRepository->getAll(['user', 'event']);
            }
        }

        $this->render('admin.subscriptions.index', compact('subscriptions', 'type'));
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $subscription         = $this->subscriptionRepository->findById($id, ['user', 'event']);
        $subscriptionStatuses = $this->subscriptionRepository->subscriptionStatuses;
        $this->render('admin.subscriptions.edit', compact('subscription', 'subscriptionStatuses'));
    }

    public function update($id)
    {
        $status = Input::get('status');

        $subscription = $this->subscriptionRepository->findById($id);
        $event = $this->eventRepository->findById($id);

        // if package requests try looping through all events
        $userId = $subscription->user_id;

        if ( $subscription->event->package ) {
            // If its a package event

            // find the package Id
            $packageId = $subscription->event->package_id;

            $package = $this->packageRepository->findById($packageId);

            // Store all the package events in an array
            foreach ( $package->events as $event ) {
                $packageArray[] = $event->id;
            }
            $packageSubscriptions = $this->subscriptionRepository->findAllPackageSubscriptionsForUser($userId, $packageArray);
            foreach ( $packageSubscriptions as $subscription ) {
                $subscriptionArray[] = $subscription->event_id;
            }

            // Compare whether user has subscribed to all the events in the package
            $hasSubscribedToWholePackage = ! array_diff($packageArray, $subscriptionArray);

            if ( $hasSubscribedToWholePackage ) {
//                dd('yes whole package');
                for ( $i = 0; $i < count($packageArray); $i ++ ) {
                    $this->subscribe($subscription, $status);
                }
                dd('subscribed to whole package');
            } else {
                dd('no');
                $this->subscribe($subscription, $status);

                dd('subscribed to package event');

            }
        } else {
//            $subscription->status = $status;
//            $email = new MessageBag();
//            $body = $email->emailBody('subscription',$status);
//            $user = User::find($userId);
//            if($subscription->save()) {
//                Mail::later(1,'site.emails.subscriptions', array('id'=>$event->id,'title_en'=>$event->title_en, 'description_en'=> $event->description_en, 'body'=> $body), function($message) use ($event, $user, $status){
//                    $message->to($user->email, $user->name_en )->subject('Kaizen - '.$event->title_en.' : Subscription '.$status);
//                });
//                return Redirect::back()->with('success', 'Event '.$status.' an email has been sent to the subscriber');
//            }
//            else {
//                return Redirect::back()->with('error', 'Not working');
//            }
        }

    }


    public function subscribe(Subscription $subscription, $status)
    {
        $subscription = new Subscriber($subscription, $status);
        $subscription->subscribe();
        if ( $subscription->messages->has('errors') ) {
            dd($subscription->messages->getMessages());

            return Redirect::home()->with('errors', $subscription->messages);
        }

        return Redirect::home()->with('success', $subscription->messages);
    }

    public function destroy()
    {

    }
}

