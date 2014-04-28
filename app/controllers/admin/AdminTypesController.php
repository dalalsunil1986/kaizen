<?php

class AdminTypesController extends AdminBaseController {


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
     * @param \Ad|\Type $model
     * @internal param \Photo $photo
     * @internal param \Post $post
     */
    public function __construct(Type $model)
    {
        $this->model = $model;
        parent::__construct();
        $this->beforeFilter('Admin');
    }


}