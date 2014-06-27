<?php namespace Acme\Core;

use McCool\LaravelAutoPresenter\BasePresenter;

class AbstractPresenter extends BasePresenter {

    public function __construct(Model $model) {
        $this->resource = $model;
    }

    public function created_at()
    {
        return $this->resource->created_at->format('Y-m-d');
    }

}
