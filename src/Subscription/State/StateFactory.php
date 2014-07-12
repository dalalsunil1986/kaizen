<?php namespace Acme\Subscription\State;

class StateFactory {

    private function __construct()
    {
        throw new \Exception('Can not instance the OrderFactory class!');
    }


    /**
     * @param $id subscriptionId
     * @return Concrete State Classes
     * @throws \Exception
     */
    public static function getStatus($id)
    {
        $status = 'Get Status From Database';

        switch ($status['status']) {
            case 'CONFIRMED':
                return new ConfirmedState();
            case 'WAITING':
                return new WaitingState();
            case 'APPROVED':
                return new ApprovedState();
            case 'REJECTED':
                return new RejectedState();
            case 'PENDING':
                return new PendingState();
            default:
                throw new \Exception('Status Class not found!');
                break;
        }
    }
}
