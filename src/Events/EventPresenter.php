<?php namespace Acme\Events;

use Acme\Core\AbstractPresenter;
use User;

class EventPresenter extends AbstractPresenter {

    /**
     * Present the created_at property
     * using a different format
     *
     * @param \Acme\Events\EventModel|\User $model
     */
    public function __construct(EventModel $model) {
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
