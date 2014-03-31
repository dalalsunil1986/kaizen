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
        $this->beforeFilter('csrf', array('on' => array('post', 'delete', 'put')));

    }

    protected function redirectToAdmin()
    {
        return Redirect::to('admin');
    }
    protected function redirectToUser()
    {
        return Redirect::to('admin/users');
    }

}