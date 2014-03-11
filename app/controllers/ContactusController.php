<?php
/**
 * Created by PhpStorm.
 * User: usama_000
 * Date: 3/11/14
 * Time: 5:49 PM
 */
use Acme\Mail\EventsMailer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ContactusController extends BaseController{

    protected $layout = 'site.layouts.home';
    function index() {
        $contact = '
        <h2 style="background-color: rgba(221, 220, 219, 0.83); padding:10px;">Contact Us</h2>
        Phone : 394893247 </br>
        Address : Address Address Address Address,</br>
        Mobile : 34324234 </br>
        ';
        $this->layout->login = View::make('site.layouts.login');
        $this->layout->ads = view::make('site.layouts.ads');
        $this->layout->nav = view::make('site.layouts.nav');
        $this->layout->maincontent = view::make('site.layouts.contactus', ['contactus'=> $contact]);
        $this->layout->sidecontent = view::make('site.layouts.sidecontent');
        $this->layout->footer = view::make('site.layouts.footer');
    }
} 