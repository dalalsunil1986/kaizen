<?php

abstract class BaseController extends Controller
{

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
        $this->beforeFilter('csrf', array('on' => array('post', 'delete', 'put')));
        $this->sidebarPosts();
        $this->getAds();
    }

    public function sidebarPosts() {
        View::composer('site.layouts.sidebar', function($view)
        {
            $latest_event_posts = EventModel::latest(4);
            $latest_blog_posts  = Post::latest(4);
            $view->with(array('latest_event_posts'=>$latest_event_posts,'latest_blog_posts'=>$latest_blog_posts));
        });
    }
    public function getAds() {
        View::composer('site.layouts.ads', function($view)
        {
            $ad1 = Ad::getAd1();
            $ad2 = Ad::getAd2();
            $view->with(array('ad1'=>$ad1,'ad2'=>$ad2));
        });
    }

    protected function findByType($id,$type,$type_string) {
        return $this->model->find($id)->where($type_string, '=', $type);
    }

    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    /**
     * @param int $perPage
     * @return mixed
     * overrides the default Eloquent all method
     */
    public function all($perPage = 8)
    {
        return $this->model->orderBy('created_at', 'DESC')->paginate($perPage);
    }

    /**
     * @param $id
     * @return mixed
     * Returns the Category For the Post, Event
     */
    public function getCategory($id)
    {
        $category = $this->model->find($id)->category;
        return $category;
    }

    /**
     * @param $id
     * @return mixed
     * Returns the Country For the Post, Event
     */
    public function getCountry($id)
    {
//        $country = $this->model->find($id)->location->country;
//        return $country;
        $this->model->find($id)->country;
//        return $country;

    }

    /**
     * @param $id
     * @return mixed
     * Returns the Location For the Post, Event
     */
    public function getLocation($id)
    {
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