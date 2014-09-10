<?php namespace Acme\Comment;

use Acme\Core\AbstractPresenter;
use Comment;

class Presenter extends AbstractPresenter {

    /**
     * Present the created_at property
     * using a different format
     *
     * @param \Acme\EventModel\EventModel|\User $model
     */
    public  $resource;

    public function __construct(Comment $model) {
        $this->resource = $model;
    }

}
