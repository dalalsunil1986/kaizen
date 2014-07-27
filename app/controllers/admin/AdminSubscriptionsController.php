<?php

use Acme\Subscription\SubscriptionRepository;

class AdminSubscriptionsController extends AdminBaseController {

    /**
     * @var Acme\Subscription\SubscriptionRepository
     */
    private $subscriptionRepository;

    function __construct(SubscriptionRepository $subscriptionRepository)
    {
        parent::__construct();
        $this->subscriptionRepository = $subscriptionRepository;
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
        dd(Input::all());
    }

    public function destroy()
    {

    }

}

