<?php

use Acme\EventModel\EventRepository;
use Acme\Payment\Methods\Paypal;
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

    public function makePayment()
    {
        $id = Input::get('payable_id');
        $payableType = Input::get('payable_type');
        $event = $this->eventRepository->findById($id);
        $baseUrl  = 'http://localhost:8000/payment/?subscription_id=1';
        $amount = $event->price;
        $description = $event->description;
        try {
            // create an entry in the database
            $paypal = new Paypal();
            $payment = $paypal->makePaymentUsingPayPal($amount, 'USD', $description,
                "$baseUrl&success=true", "$baseUrl&success=false");
            // update database with status
            // $payment->getState();
            // payment id dd($payment->getId());
            header("Location: " . $this->getLink($payment->getLinks(),'approval_url')) ;
            exit;

        } catch (PPConnectionException $ex) {
            $message = parseApiError($ex->getData());
            $messageType = "error";
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $messageType = "error";
        }
    }

    public function process(){
        dd(Input::all());
    }

    public function getLink(array $links, $type) {
        foreach($links as $link) {
            if($link->getRel() == $type) {
                return $link->getHref();
            }
        }
        return "";
    }
}