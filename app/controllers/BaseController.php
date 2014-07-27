<?php

abstract class BaseController extends Controller {

    // define the master layout for the site
    protected $layout = 'site.master';

    // title of the page
    protected $title = '';

    /**
     * Initializer.
     *
     * @access   public
     * @return \BaseController
     */
    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => array('post', 'delete', 'put')));
        $this->sidebarPosts();
        $this->getAds();
    }

    protected function setupLayout()
    {
        if ( ! is_null($this->layout) ) {
            $this->layout = View::make($this->layout);
        }
    }

    /**
     * @param $path
     * @param array $data
     * render the view
     */
    protected function render($path, $data = [])
    {
        $this->layout->title   = $this->title;
        $this->layout->content = View::make($path, $data);
    }

    protected function redirectIntended($default = null)
    {
        $intended = Session::get('auth.intended_redirect_url');
        if ( $intended ) {
            return Redirect::to($intended);
        }

        return Redirect::to($default);
    }

    public function sidebarPosts()
    {
        View::composer('site.events.latest', function ($view) {
            $latest_event_posts = App::make('EventModel')->latest(4);
            $view->with(array('latest_event_posts' => $latest_event_posts));
        });
        View::composer('site.blog.latest', function ($view) {
            $latest_blog_posts = App::make('Post')->latest(4);
            $view->with(array('latest_blog_posts' => $latest_blog_posts));
        });
    }

    public function getAds()
    {
        View::composer('site.layouts.ads', function ($view) {
            $ad1 = App::make('ad')->getAd1();
            $ad2 = App::make('ad')->getAd2();
            $view->with(array('ad1' => $ad1, 'ad2' => $ad2));
        });
    }

    /**
     * Helper Functions
     */
    protected function view($path, $data = [])
    {
        $this->layout->content = View::make($path, $data);
    }

    protected function redirectTo($url, $statusCode = 302)
    {
        return Redirect::to($url, $statusCode);
    }

    protected function redirectAction($action, $data = [])
    {
        return Redirect::action($action, $data);
    }

    protected function redirectRoute($route, $data = [])
    {
        return Redirect::route($route, $data);
    }

    protected function redirectBack($data = [])
    {
        return Redirect::back()->withInput()->with($data);
    }

}