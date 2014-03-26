<?php

class AdsController extends BaseController {


    /**
     * Post Model
     * @var Post
     */
    protected $model;

    /**
     * Inject the models.
     * @param Ad $model
     * @internal param \Post $post
     */
    public function __construct(Ad $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    public function getAd1() {
         $image = $this->model->getAd1()->pluck('name');
         return $image;
    }

    public function getAd2() {
        $image = $this->model->getAd2()->pluck('name');
        return $image;
    }

}