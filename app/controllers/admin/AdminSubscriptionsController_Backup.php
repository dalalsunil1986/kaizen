<?php

use Acme\Event\EventRepository;
use Acme\Package\PackageRepository;
use Acme\Subscription\State\Subscriber;
use Acme\Subscription\SubscriptionRepository;
use Acme\User\UserRepository;

class AdminSubscriptionsController_Backup extends AdminBaseController {

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

        // if subscription event has a package parent id,
        // then find all the subscriptions for that user for the package,
        // and find all the events for that package
        // and find if he has subscribed to all events from the package ( if event_id from subscriptions table matches package->events)

        $subscription = $this->subscriptionRepository->findById($id);

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

                foreach ( $packageArray as $package ) {
                    $this->setStatus($id, $status);
                    $this->subscribe($subscription);
                }

                dd('subscribed to whole package');
            } else {
                $this->setStatus($id, $status);
                $this->subscribe($subscription);

                dd('subscribed to package event');

            }
        } else {
            $this->setStatus($id, $status);
            $this->subscribe($subscription);
            dd('subscribed to single event');
        }

    }

    public function setStatus($id, $status)
    {
        $subscription         = $this->subscriptionRepository->findById($id);
        $subscription->status = $status;
        $subscription->save();
    }

    public function subscribe($subscription)
    {
        $subscription = new Subscriber($subscription);
        $subscription->subscribe();
    }

    public function destroy()
    {

    }
}

