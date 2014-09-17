<?php

use Acme\Core\LocaleTrait;
use Carbon\Carbon;
use McCool\LaravelAutoPresenter\PresenterInterface;

class EventModel extends BaseModel implements PresenterInterface {

    use LocaleTrait;

    protected $guarded = ['id'];

    protected $localeStrings = ['title', 'description', 'address', 'street', 'button'];

    protected $table = "events";

    protected static $name = "event";

    public function comments()
    {
        return $this->morphMany('Comment', 'commentable');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function author()
    {
        return $this->belongsTo('User', 'user_id')->select('id', 'username', 'email');
    }

    public function categories()
    {
        return $this->belongsTo('Category', 'category_id')->select('name', 'name_en', 'type', 'slug');
    }

    public function followers()
    {
        return  $this->belongsToMany('User', 'followers', 'event_id', 'user_id');
    }

    public function favorites()
    {
        return $this->belongsToMany('User', 'favorites', 'event_id', 'user_id');
    }

//    public function subscriptions() {
//        return $this->belongsToMany('User', 'subscriptions','event_id','user_id');
//    }

    public function subscribers()
    {
        return $this->belongsToMany('User', 'subscriptions', 'event_id', 'user_id');
    }

    public function requests()
    {
        return $this->belongsToMany('User', 'requests', 'event_id', 'user_id');
    }


    /**
     * gets the past events
     */
    public function getPastEvents()
    {
        return DB::table('events AS e')
            ->join('photos AS p', 'e.id', '=', 'p.imageable_id', 'LEFT')
            ->where('p.imageable_type', '=', 'EventModel')
            ->where('e.date_start', '<', Carbon::now()->toDateTimeString());
    }

    /**
     * @param int $days
     * @return \Illuminate\Database\Query\Builder|static
     * get Recent Event by Days
     */
    public static function getRecentEvents($days)
    {
        $dt = Carbon::now()->addDays($days);

        return DB::table('events AS e')
            ->join('photos AS p', 'e.id', '=', 'p.imageable_id', 'LEFT')
            ->where('p.imageable_type', '=', 'EventModel')
            ->where('e.date_start', '<', $dt->toDateTimeString());
    }

    public function getRelatedEvents()
    {

    }

    public function category()
    {
        return $this->belongsTo('Category', 'category_id');
    }

    public function  location()
    {
        return $this->belongsTo('Location');
    }

    public function photos()
    {
        return $this->morphMany('Photo', 'imageable');
    }

    // @todo : replace this func
    public static function fixEventCounts($id, $count)
    {
        //        $event = EventModel::find($id);
        //        $event->available_seats = $event->total_seats - $count;
        //        $event->save();
    }

    public function formatEventDate($column)
    {
        $dt = Carbon::createFromTimestamp(strtotime($column));

        return $dt->format('D, jS \\of M Y');
    }

    public function formatEventTime($column)
    {
        $dt = Carbon::createFromTimestamp(strtotime($column));

        return $dt->format('g a');
    }

    public function latest($count)
    {
        return EventModel::orderBy('created_at', 'DESC')->select('id','title_ar','slug','title_en')->remember(10)->limit($count)->get();
    }

    public function getDates()
    {
        return array_merge(array(static::CREATED_AT, static::UPDATED_AT), array('date_start', 'date_end'));
    }

    public function setDateStartAttribute($value)
    {
        $this->attributes['date_start'] = $this->dateStringToCarbon($value);
    }

    public function setDateEndAttribute($value)
    {
        $this->attributes['date_end'] = $this->dateStringToCarbon($value);
    }

    public function type()
    {
        return $this->hasOne('Type', 'event_id');
    }

    public function statuses()
    {
        return $this->belongsToMany('User', 'statuses', 'event_id', 'user_id')->withPivot(array('id', 'event_id', 'user_id', 'status'));
//        return $this->hasMany('Subscription','event_id');
    }

    /**
     * @return $this
     * used while a seat is confirmed
     * decrements availableSeats by 1
     */
    public function decrementAvailableSeats()
    {
        $totalSeats = $this->total_seats;
        if ( $totalSeats > 0 ) {
            $totalSubscriptions    = DB::table('subscriptions')->where('status','CONFIRMED')->count();
            $this->available_seats = $totalSeats - $totalSubscriptions;
            $this->save();
            return $this;
        }
    }

    public function incrementAvailableSeats()
    {
        $this->available_seats = $this->available_seats+ 1;
        $this->save();
        dd($this->available_seats);
        return $this;
    }
    /**
     * Get the presenter class.
     *
     * @return string The class path to the presenter.
     */
    public function getPresenter()
    {
        return 'Acme\EventModel\Presenter';
    }

    public function getHumanCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();

        return null;
    }

    protected function dateStringToCarbon($date, $format = 'm/d/Y')
    {
        if ( ! $date instanceof Carbon ) {
            $validDate = false;
            try {
                $date      = Carbon::createFromFormat($format, $date);
                $validDate = true;
            }
            catch ( Exception $e ) {
            }

            if ( ! $validDate ) {
                try {
                    $date      = Carbon::parse($date);
                    $validDate = true;
                }
                catch ( Exception $e ) {
                }
            }

            if ( ! $validDate ) {
                $date = null;
            }
        }

        return $date;
    }

    public function setTotalSeatsAttribute($value)
    {
        $this->attributes['total_seats'] = (int) ($value);
    }

    public function setLatitudeAttribute($value)
    {
        $this->attributes['latitude'] = floatval($value);
    }

    public function setLongitudeAttribute($value)
    {
        $this->attributes['longitude'] = floatval($value);
    }

    public function subscriptions()
    {
        return $this->hasMany('Subscription', 'event_id');
    }

    public function setting()
    {
        return $this->morphOne('Setting', 'settingable');
    }

    public function hasAvailableSeats()
    {
        return $this->available_seats > 0 ? true : false;
    }

    public function package()
    {
        return $this->belongsTo('Package');
    }

    public function beforeDelete(){

        //delete settings
        $this->setting()->delete();

        foreach ($this->subscriptions()->get(array('id')) as $subscription) {
            $subscription->delete();
        }
    }

    public function tags()
    {
        return $this->morphToMany('Tag', 'taggable');
    }

    public function getConfirmedUsers(){
        return $this->whereHas('subscriptions',function($q)
        {
            $q->where('status','=','CONFIRMED');
        })->get();
    }

    public function scopeNotExpired($query){
        return $query->where('date_start','>',Carbon::now()->toDateTimeString());
    }

    public function isAuthor($userId)
    {
        return $this->user_id === $userId ? true : false;
    }
}

