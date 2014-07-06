<?php



abstract class AdminBaseController extends BaseController
{
    protected $layout = 'admin.master';

    public function __construct() {
        parent::__construct();
    }
}