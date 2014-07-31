<?php namespace Acme\Blog;

use Acme\Core\AbstractPresenter;
use Blog;

class Presenter extends AbstractPresenter {

    public function __construct(Blog $model) {
        $this->resource = $model;
    }

}
