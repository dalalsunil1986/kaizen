<?php

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

abstract class AdminBaseController extends BaseController
{

    //Inject the Model into the Constructor method of the controller

    protected $model;
//    protected $layout = 'site.layouts.default';

    /**
     * Initializer.
     *
     * @access   public
     * @return \AdminBaseController
     */
    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('admin-auths');
    }

    protected function redirectToAdmin()
    {
        return Redirect::to(LaravelLocalization::localizeUrl('admin'));
    }
    protected function redirectToUser()
    {
        return Redirect::to(LaravelLocalization::localizeUrl('admin/users'));
    }

}