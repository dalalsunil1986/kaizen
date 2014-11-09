<?php namespace Acme\EventModel;

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

        return $this->model->with($with)//->where('date_start', '>', $currentTime)
        ;

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
            ->where('date_start','>',Carbon::now())
            ->where('date_end','>',Carbon::now())
            ->orderBy('date_start', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);
    }

    /**
     * Return Events For Event Index Page
     * @param $perPage
     * @return mixed
     *
     */
    public function getPastEvents($perPage = 10)
    {
        return $this->getAll()
            ->where('date_start','<',Carbon::now())
            ->orderBy('date_start', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);
    }

    /**
     * @return array|null|static[]
     * Fetch Posts For Sliders
     */

    // Afdal that's so weird .. this function is repeated in EventRepository and EventsController !!!!!!!!!!!!!!!!!!!!!!!!!

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
            ->where('p.imageable_type', '=', 'EventModel')
            ->whereIn('e.id', $array)
            ->take($limit)
            ->groupBy('e.id')
            ->get(array('e.id', 'e.title_ar', 'e.title_en', 'e.description_ar', 'e.description_en', 'p.name', 'e.button_ar', 'e.button_en'));

        return $events;
    }


    function suggestedEvents($eventId)
    {
        $current_event            = $this->findById($eventId);
        $current_event_tags       = $this->model->tags->get();
        $current_event_categories = $this->model->categories()->get();
        echo '<pre>';
        print_r($current_event_tags);
        echo '<pre>';
        print_r($current_event_categories);
        exit;
//        $event = $this->get()->where('tag_id' , '=', )
    }

    /**
     * @param $dateStart
     * @return bool
     * check if the event expired
     */
    public function eventExpired($dateStart)
    {
        $expired = false;
        $now     = Carbon::now();
        if ( $now > $dateStart ) {
            $expired = true;
        }

        return $expired;
    }

    /**
     * @param $startDate DateTimeString
     * @param $endDate DateTimeString
     * @return bool
     */
    public function ongoingEvent($startDate, $endDate)
    {
        $ongoing = false;
        $now     = Carbon::now();
        // if event starting time is greater then now ( if now is not greater than event ending time ) it is an ongoing event
        if($now->addHours(5) > $startDate) {
            if(!($now > $endDate) ) {
                $ongoing = true;
            }
        }
        return $ongoing;
    }


    /**
     * @param $id Event Id
     */
    public function getSuggestedEvents($id)
    {
        // get 1 random post for tags
        // get 1 random post for categories
//        $events =
    }



    public function updateAvailableSeatsOnUpdate()
    {
        // check if the total_seats has changed

        // If the total_seats has been incremented ex:20
        // The available seats = 5
        // Find the amount of incremented seats : 10
        // Find the seats that are already booked : old_total_seats - available_seats = 15
        // Update available seats

//        $this->model->available_seats = $this->model->total_seats;
//        $this->model->save();
    }

    public function getExpiredEvents()
    {
        return $this->where('date_start', '<',Carbon::now())->get();
    }

}