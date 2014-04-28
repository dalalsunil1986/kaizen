<?php

class AdminStatusesController extends AdminBaseController {


    /**
     * Post Model
     * @var Post
     */
    protected $model;
    /**
     * @var Photo
     */
    protected $photo;

    /**
     * Inject the models.
     * @param Status $model
     * @internal param \Post $post
     */
    public function __construct(Status $model)
    {
        $this->model = $model;
        parent::__construct();
        $this->beforeFilter('Admin');
    }




}