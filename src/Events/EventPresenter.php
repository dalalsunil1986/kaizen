<?php namespace Acme\Events;

use Acme\Core\AbstractPresenter;
use User;

class EventPresenter extends AbstractPresenter {

    /**
     * Present the created_at property
     * using a different format
     *
     * @param User $model
     * @internal param \Kuwaitii\Users\User $user
     * @return \Kuwaitii\Users\UserPresenter
     */
    public function __construct(User $model) {
        $this->resource = $model;
    }

    public function created_at()
    {
        return $this->resource->created_at->format('Y-m-d');
    }

    public function email() {
        return 'haha ' . $this->resource->email;
    }

}
