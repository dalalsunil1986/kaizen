<?php

use Acme\EventModel\EventRepository;
use Acme\Libraries\UserCurrency;
use Acme\Payment\Methods\Paypal;
use Acme\Payment\PaymentRepository;

class PaymentsController extends BaseController {

    /**
     * Post Model
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
     * @var UserCurrency
     */
    private $converter;

    private $defaultCurrency = 'USD';
    /**
     * @var Paypal
     */
    private $paypal;

    /**
     * Inject the models.
     * @param PaymentRepository $paymentRepository
     * @param EventRepository $eventRepository
     * @param UserCurrency $converter
     * @param Paypal $paypal
     */
    public function __construct(PaymentRepository $paymentRepository, EventRepository $eventRepository, UserCurrency $converter, Paypal $paypal)
    {
        $this->paymentRepository = $paymentRepository;
        $this->eventRepository   = $eventRepository;
        $this->converter         = $converter;
        $this->beforeFilter('auth');
        parent::__construct();
        $this->paypal = $paypal;
    }

    /**
     * @param $id
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
        $payableId = Input::get('event_id');

        $token = Input::get('token'); // payment token

        $paymentRepo = $this->paymentRepository->findByToken($token);

        $paymentRepo->method = 'paypal';

        $event = $this->eventRepository->findById($payableId);

        $convertedPrice = $this->converter->convert($this->defaultCurrency, $event->price);

        if ( $convertedPrice <= 0 ) {
            return Redirect::back('/')->with('error', trans('word.system_error'));
        }

        $paymentRepo->amount = $convertedPrice;

        $paymentRepo->currency = $this->defaultCurrency;

        $description = $event->description;

        $baseUrl = App::make('url')->action('PaymentsController@getFinal') . '?t=' . $token;

        $item = ['title'=>$event->title,'amount'=>$paymentRepo->amount,'description'=>$event->description];
        try {
            // Instantiate Paypal Class
            $payer = $this->paypal;

            // Make Payment
            $payment = $payer->makePayment($paymentRepo->amount, 'USD', $description , "$baseUrl&success=true", "$baseUrl&success=false",$item);

            $paymentRepo->transaction_id = $payment->getId();

            $paymentRepo->save();

            // Redirect With Payment Params
            header("Location: " . $this->getLink($payment->getLinks(), 'approval_url'));

            exit;

        }

        catch ( Exception $e ) {
            // Set Status To Error

            $paymentRepo->status = 'ERROR';

            $paymentRepo->save();

            return Redirect::back()->with('info', 'Some Error occurd While completing the transaction, Please try again');
        }

//        stub
//        header("Location: http://localhost:8000/payment/final?t=18d852081b78d11dfb31744b62c6e67d&success=true&paymentId=PAY-0D169573GL1889143KRI65GA&token=EC-81G465939D677172H&PayerID=33D2575LNZS66");
//        exit;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * Lands to this page right after the Payment Process
     */
    public function getFinal()
    {
        $token = Input::get('t'); // site generated token

        $payment = $this->paymentRepository->findByToken($token);

        if ( !$payment ) {
            return Redirect::action('EventsController@index')->with('error', 'Invalid Token');
        }

        $payment->payer_id    = Input::get('PayerID');
        $payment->payment_token = Input::get('token'); // token from the payment vendor

        if ( Input::get('success') == true ) {

            $payer = new Paypal();

            $payer->executePayment($payment->transaction_id,$payment->payer_id);

            $payment->status = 'CONFIRMED';
            $payment->token  = ''; // set token to null
            $payment->save();

            // Subscribe the User
            $controller = App::make('SubscriptionsController');

            // Get The Event to Pass to the Subscription Function
            $event = $payment->payable->event;
            $controller->callAction('subscribe', [$event->id, 'PAYMENT']); //todo pass the event ID

            return Redirect::action('EventsController@getSuggestedEvents', $event->id)->with('success', 'You have been subscribed to this Event');

        }
        // If Transaction Failed
        $payment->status = 'REJECTED';
        $payment->save();

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