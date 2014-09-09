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

        if ( !isset($type) ) {
            $type = 'event';
        } else {
            $type = Input::get('type');
        }

        if ( $type == 'event' ) {
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

    /**
     * @param $id
     * @throws \Acme\Core\Exceptions\EntityNotFoundException
     * Update Status of the user
     */
    public function update($id)
    {
        $status       = Input::get('status');
        $feedback     = Input::get('feedback');
        $subscription = $this->subscriptionRepository->findById($id);
        $userId       = $subscription->user_id;

        // check if the status that is being updated is not the current state
        if ( $subscription->status == $status ) {

            return Redirect::back()->with('error', 'The user is already ' . ucwords(strtolower($status)));
        }

        // if package requests try looping through all events
        if ( $subscription->event->package ) {

            // If its a package event, find the package Id
            $packageId = $subscription->event->package_id;

            $package = $this->packageRepository->findById($packageId);

            // Store all the package events in an array
            foreach ( $package->events as $event ) {
                $packageArray[] = $event->id;
            }

            // Find all the events subscribed by the user for the current package
            $packageSubscriptions = $this->subscriptionRepository->findAllPackageSubscriptionsForUser($userId, $packageArray);

            // Loop through the all the subscription of the user for the current package and store it an array
            foreach ( $packageSubscriptions as $subscription ) {
                $subscriptionArray[] = $subscription->event_id;
            }

            // Compare whether user has subscribed to all the events in the package
            $hasSubscribedToWholePackage = !array_diff($packageArray, $subscriptionArray);

            if ( $hasSubscribedToWholePackage ) {
                for ( $i = 0; $i < count($packageArray); $i ++ ) {
                    $this->subscribe($subscription, $status, $feedback);
                }
            } else {
                $this->subscribe($subscription, $status, $feedback);
            }

        } else {
            $this->subscribe($subscription, $status, $feedback);
        }

    }


    public function subscribe(Subscription $subscription, $status, $feedback)
    {
        $subscriber = new Subscriber($subscription, $status, $feedback);
        $subscriber->subscribe();

        if ( $subscriber->messages->has('errors') ) {

            return Redirect::home()->with('errors', $subscriber->messages->all());
        }

        return Redirect::home()->with('success', $subscriber->messages);
    }

    public function destroy()
    {

    }
}

