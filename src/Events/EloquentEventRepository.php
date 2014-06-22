<?php namespace Acme\Events;

use Acme\Core\CrudableTrait;
use Carbon\Carbon;
use EventModel;
use Illuminate\Support\MessageBag;
use Acme\Core\Repositories\Illuminate;
use Acme\Core\Repositories\AbstractRepository;

class EloquentEventRepository extends AbstractRepository  {

    use CrudableTrait;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * Construct
     *
     * @param \EventModel|\Illuminate\Database\Eloquent\Model $model
     * @internal param \Illuminate\Database\Eloquent\Model $user
     */
    public function __construct(EventModel $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

    public function findAll()
    {
        $currentTime = Carbon::now()->toDateTimeString();

        $events = $this->model->with(array('category', 'location.country', 'photos', 'author'))
                    ->where('date_start', '>', $currentTime)
        ;

        return $events;
    }

    /**
     * Return Events For Event Index Page
     * @param $perPage
     * @return mixed
     *
     */
    public function getEvents($perPage = 10)
    {
        return $this->findAll()
            ->orderBy('date_start', 'DESC')
            ->paginate($perPage);
    }

}