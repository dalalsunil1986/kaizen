<?php

abstract class BaseController extends Controller {

    //Inject the Model into the Constructor method of the controller
    
    protected $model;
//    protected $layout = 'site.layouts.default';

    /**
     * Initializer.
     *
     * @access   public
     * @return \BaseController
     */
    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    protected function setupLayout()
    {
        if ( ! is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }


    /**
     * @param int $perPage
     * @return mixed
     * overrides the default Eloquent all method
     */
    public  function all($perPage = 10) {
        return $this->model->orderBy('created_at', 'DESC')->paginate($perPage);
    }

    /**
     * @param $id
     * @return mixed
     * Returns the Category For the Post, Event
     */
    public function getCategory($id) {
        $category = $this->model->find($id)->category;
        return $category;
    }
    /**
     * @param $id
     * @return mixed
     * Returns the Followers For the Post, Event
     */
    public function getFollowers($id) {
        $followers = $this->model->find($id)->followers;
        return $followers;
    }

    /**
     * @param $id
     * @return mixed
     * Returns the Favorites For the Post, Event
     */
    public function getFavorites($id) {
        $favorites = $this->model->find($id)->favorites;
        return $favorites;
    }
    /**
     * @param $id
     * @return mixed
     * Returns the Subscriptions For the Post, Event
     */
    public function getSubscriptions($id) {
        $subscriptions = $this->model->find($id)->subscriptions;
        return $subscriptions;
    }
    /**
     * @param $id
     * @return mixed
     * Returns the Country For the Post, Event
     */
    public function getCountry($id) {
        $country = $this->model->find($id)->location->country;
        return $country;
    }
    /**
     * @param $id
     * @return mixed
     * Returns the Location For the Post, Event
     */
    public function getLocation($id) {
        $location = $this->model->find($id)->location;
        return $location;
    }


    /*
     *Helper Functions
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

    protected function redirectIntended($default = null)
    {
        return Redirect::intended($default);
    }
}