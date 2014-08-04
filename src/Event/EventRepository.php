<?php namespace Acme\Event;

use Acme\Core\CrudableTrait;
use Carbon\Carbon;
use DB;
use EventModel;
use Acme\Core\Repositories\Illuminate;
use Acme\Core\Repositories\AbstractRepository;

class EventRepository extends AbstractRepository {

    use CrudableTrait;

    public $model;

    public function __construct(EventModel $model)
    {
        $this->model = $model;
    }

    public function getAll($with = [])
    {
        $currentTime = Carbon::now()->toDateTimeString();

        return $this->model->with($with)
            ->where('date_start', '>', $currentTime);

    }

    /**
     * Return Events For Event Index Page
     * @param $perPage
     * @return mixed
     *
     */
    public function getEvents($perPage = 10)
    {
        return $this->getAll()
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
    public function mergeSliderEvents($limit, $array)
    {
        $events = DB::table('events AS e')
            ->join('photos AS p', 'e.id', '=', 'p.imageable_id', 'LEFT')
            ->whereIn('e.id', $array)
            ->take($limit)
            ->groupBy('e.id')
            ->get(array('e.id', 'e.title', 'e.title_en', 'e.description', 'e.description_en', 'p.name', 'e.button', 'e.button_en'));

        return $events;
    }

}