<?php

use Acme\Event\EventRepository;
use Acme\Package\PackageRepository;
use Acme\Subscription\State\Admin\Subscriber;
use Acme\Subscription\SubscriptionRepository;
use Acme\User\UserRepository;

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
        $subscriptions = $this->subscriptionRepository->getAll(['user', 'event']);
        $this->render('admin.subscriptions.index', compact('subscriptions'));
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

        // if package requests try looping through all events
        $userId = $subscription->user_id;

        if ( $subscription->event->package ) {
            // If its a package event

            // find the package Id
            $packageId = $subscription->event->package_id;

            $packages = $this->packageRepository->findById($packageId);

            // Store all the package events in an array
            foreach ( $packages->events as $package ) {
                $packageArray[] = $package->id;
            }

            $packageSubscriptions = $this->subscriptionRepository->findAllPackageSubscriptionsForUser($userId, $packageArray);

            foreach ( $packageSubscriptions as $subscription ) {
                $subscriptionArray[] = $subscription->event_id;
            }

            // Compare whether user has subscribed to all the events in the package
            $hasSubscribedToWholePackage = ! array_diff($packageArray, $subscriptionArray);

            if ( $hasSubscribedToWholePackage ) {

                for ( $i = 0; $i < $packageArray; $i++ ) {
                    $this->subscribe($subscription, $status);
                }
                dd('subscribed to whole package');
            } else {
                $this->subscribe($subscription, $status);

                dd('subscribed to package event');

            }
        } else {
            $this->subscribe($subscription, $status);
            dd('subscribed to single event');
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

