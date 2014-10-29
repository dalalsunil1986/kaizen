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
        $this->eventRepository   = $eventRepository;
    }

    /**
     * @param $id
     * @param $token
     * Lands on this page when link from email is clicked
     */
    public function getPayment($id)
    {
        $event = $this->eventRepository->findById($id);

        if ( $this->eventRepository->eventExpired($event->date_start) ) {
            return Redirect::action('EventsController@index')->with('error', 'Event Expired');
        }

        $payment = $this->paymentRepository->findByToken(Input::get('token'));

        if ( !$payment ) {
            return Redirect::action('EventsController@index')->with('error', 'Token Expired');
        }

        $this->render('site.events.payment-options', compact('event', 'payment'));
    }

    public function postPayment()
    {
        $payableId   = Input::get('event_id');
        $method      = 'paypal'; //Input::get('method'); // For Now Paypal
        $event       = $this->eventRepository->findById($payableId);
        $amount      = $event->price;
        $token       = Input::get('token'); // payment token
        $baseUrl     = App::make('url')->action('PaymentsController@getFinal') . '?t=' . $token;
        $description = $event->description;
        $paymentRepo = $this->paymentRepository->findByToken($token);
        try {
            $paypal              = new Paypal();
            $payment             = $paypal->makePaymentUsingPayPal($amount, 'USD', $description, "$baseUrl&success=true", "$baseUrl&success=false");
            $paymentRepo->status = $payment->getState();
            $payment->payer_id   = $payment->getId();
            $paymentRepo->save();
            header("Location: " . $this->getLink($payment->getLinks(), 'approval_url'));
            exit;
        }
        catch ( PPConnectionException $ex ) {
            $message     = parseApiError($ex->getData());
            $messageType = "error";
        }
        catch ( Exception $ex ) {
            $message     = $ex->getMessage();
            $messageType = "error";
        }
    }

    public function getFinal()
    {
        $token   = Input::get('t'); // site generated token
        $payment = $this->paymentRepository->findByToken($token);

        if ( !$payment ) {

            return Redirect::action('EventsController@index')->with('error', 'Invalid Token');
        }

        $payment->payment_id    = Input::get('paymentId');
        $payment->payment_token = Input::get('token');

        if ( Input::get('success') == true ) {

            $payment->status = 'CONFIRMED';
            $payment->token  = ''; // set token to null
            $payment->save();
            $controller = App::make('SubscriptionsController');
            $controller->callAction('subscribe', [1]);

            return Redirect::action('EventsController@index')->with('success', 'Success');

        }

        return Redirect::action('EventsController@index')->with('error', 'Could Not Subscribe You');


    }

    public function getLink(array $links, $type)
    {
        foreach ( $links as $link ) {
            if ( $link->getRel() == $type ) {
                return $link->getHref();
            }
        }

        return "";
    }
}