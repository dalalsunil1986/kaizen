<?php namespace Acme\Payment;

use Acme\Core\Repositories\AbstractRepository;
use Acme\Core\Repositories\Illuminate;
use Payment;

class PaymentRepository extends AbstractRepository {

    public $paymentMethds = ['paypal'];

    /**
     * @param Payment $model
     */
    public function __construct(Payment $model)
    {
        $this->model = $model;
    }



}