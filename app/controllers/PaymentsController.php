<?php

use Acme\EventModel\EventRepository;
use Acme\Payment\PaymentRepository;

class PaymentsController extends BaseController {


    /**
     * Post Model
     * @var Post
     */
    protected $model;
    /**
     * @var PaymentRepository
     */
    private $paymentRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * Inject the models.
     * @param PaymentRepository $paymentRepository
     * @param EventRepository $eventRepository
     * @internal param Ad $model
     * @internal param \Post $post
     */
    public function __construct(PaymentRepository $paymentRepository, EventRepository $eventRepository)
    {
        parent::__construct();
        $this->paymentRepository = $paymentRepository;
        $this->eventRepository = $eventRepository;
    }

    public function getPayment($id)
    {
        $event = $this->eventRepository->findById($id);
        $this->render('site.events.payment-options',compact('event'));
    }
}