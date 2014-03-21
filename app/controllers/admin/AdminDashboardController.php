<?php

class AdminDashboardController extends AdminBaseController {

	/**
	 * Admin dashboard
	 *
	 */
	public function getIndex()
	{
        return View::make('admin/dashboard');
	}

}