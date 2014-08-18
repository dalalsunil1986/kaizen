<?php namespace Acme\User;

use Acme\Core\AbstractPresenter;
use User;

class Presenter extends AbstractPresenter {

    public function __construct(User $model) {
        $this->resource = $model;
    }

}
