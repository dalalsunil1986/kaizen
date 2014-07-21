<?php namespace Acme\Event;

use Acme\Core\AbstractPresenter;
use EventModel;
use User;

class EventPresenter extends AbstractPresenter {

    /**
     * Present the created_at property
     * using a different format
     *
     * @param \Acme\Event\EventModel|\User $model
     */
    public  $resource;

    public function __construct(EventModel $model) {
        $this->resource = $model;
    }

    public function created_at()
    {
        return $this->resource->created_at->format('Y-m-d');
    }

    public function date_start()
    {
        return $this->resource->date_start->format('Y-m-d');
    }

}
