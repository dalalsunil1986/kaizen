<?php namespace Acme\Events;

use Acme\Core\CrudableTrait;
use Carbon\Carbon;
use DB;
use EventModel;
use Illuminate\Support\MessageBag;
use Acme\Core\Repositories\Illuminate;
use Acme\Core\Repositories\AbstractRepository;

class EloquentEventRepository extends AbstractRepository {

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
            ->where('date_start', '>', $currentTime);

        return $events;
    }

//    public function find($id)
//    {
//        $event = $this->model->with('comments', 'author', 'photos', 'subscribers', 'followers', 'favorites')->findOrFail($id)->get();
//
//        if(!$event)
//            App::abort('404');
//
//        $currentTime = Carbon::now()->toDateTimeString();
//
//        $events = $this->model->with(array('category', 'location.country', 'photos', 'author'))
//            ->where('date_start', '>', $currentTime);
//
//        return $events;
//    }




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

    /**
     * @return array|null|static[]
     * Fetch Posts For Sliders
     */
    public function getSliderEvents()
    {
        // fetch 3 latest post
        // fetches 2 featured post
        // order by event date, date created, featured
        // combines them into one query to return for slider

        $latestEvents   = $this->latestEvents();
        $featuredEvents = $this->feautredEvents();
        $events         = array_merge((array) $latestEvents, (array) $featuredEvents);
        if ( $events ) {
            foreach ( $events as $event ) {
                $array[] = $event->id;
            }
            $events_unique = array_unique($array);
            $sliderEvents  = $this->mergeSliderEvents(6, $events_unique);

            return $sliderEvents;
        } else {
            return null;
        }

    }

    /**
     * Fetches posts for latest Event
     * @return array
     *
     */
    public function latestEvents()
    {
        return DB::table('events as e')
            ->join('photos as p', 'e.id', '=', 'p.imageable_id', 'LEFT')
            ->where('p.imageable_type', '=', 'EventModel')
            ->where('e.date_start', '>', Carbon::now()->toDateTimeString())
            ->orderBy('e.date_start', 'DESC')
            ->orderBy('e.created_at', 'DESC')
            ->take('5')
            ->get(array('e.id'));
    }

    /**
     * Fetches posts for latest Event
     * @return array
     *
     */
    public function feautredEvents()
    {
        return DB::table('events AS e')
            ->join('photos AS p', 'e.id', '=', 'p.imageable_id', 'LEFT')
            ->where('p.imageable_type', '=', 'EventModel')
            ->where('e.date_start', '>', Carbon::now()->toDateTimeString())
            ->where('e.featured', '1')
            ->orderBy('e.date_start', 'DESC')
            ->orderBy('e.created_at', 'DESC')
            ->take('5')
            ->get(array('e.id'));
    }

    /**
     * @param $limit
     * @param $array
     * @return array|static[]
     * Merge Slider Events
     */
    public function mergeSliderEvents($limit, $array) {
        $events = DB::table('events AS e')
            ->join('photos AS p', 'e.id', '=', 'p.imageable_id', 'LEFT')
            ->whereIn('e.id',$array)
            ->take($limit)
            ->groupBy('e.id')
            ->get(array('e.id','e.title','e.title_en','e.description','e.description_en','p.name','e.button','e.button_en'));
        return $events;
    }
}