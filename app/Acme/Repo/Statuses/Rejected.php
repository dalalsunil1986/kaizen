<?php
/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 5/2/14
 * Time: 3:28 AM
 */

namespace Acme\Repo\Statuses;


class Rejected extends Status implements StatusInterface {

    public function __construct() {

    }

    public function setStatus($event, $user, $status)
    {
        // TODO: Implement setStatus() method.
    }
}