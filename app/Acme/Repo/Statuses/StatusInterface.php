<?php
/**
 * Created by PhpStorm.
 * User: ZaL
 * Date: 5/2/14
 * Time: 3:25 AM
 */

namespace Acme\Repo\Statuses;


interface StatusInterface {
    public function setAction($event,$user,$status);
}