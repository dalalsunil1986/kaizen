<?php
/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 5/2/14
 * Time: 4:22 AM
 */

namespace Acme\Repo\Statuses;


class StatusFactory
{
    /**
     * @var array
     */
    protected $typeList;

    /**
     * You can imagine to inject your own type list or merge with
     * the default ones...
     */
    public function __construct()
    {
        $this->typeList = array(
            'APPROVED' => __NAMESPACE__ . '\Approved',
            'REJECTED' => __NAMESPACE__ . '\Rejected',
            'PENDING'  => __NAMESPACE__ . '\Pending',
            'CONFIRMED'  => __NAMESPACE__ . '\Confirmed',
        );
    }

    /**
     * Creates a vehicle
     *
     * @param string $type a known type key
     *
     * @return VehicleInterface a new instance of VehicleInterface
     * @throws \InvalidArgumentException
     */
    public function createVehicle($type)
    {
        if (!array_key_exists($type, $this->typeList)) {
            throw new \InvalidArgumentException("$type is not valid vehicle");
        }
        $className = $this->typeList[$type];

        return new $className();
    }
}