<?php

class EventModel extends BaseModel {
	protected $guarded = array();

	public static $rules = array(
        'title'=>'required',
        'description'=>'required',
        'user_id' => 'required',
        'category_id' => 'required',
        'location_id' =>'required'
    );
    /**
     * @var
     */

    protected static function boot()
    {

        parent::boot();

        static::saving(function($model)
        {
            return $model->validate();
        });
    }

    protected  $table = "events";

    public function comments() {
        return $this->morphMany('Comment','commentable');
    }

    /**
     * get the person who added the event
     */
    public function user() {
        return $this->belongsTo('User');
    }

    public function author() {
        return $this->belongsTo('User','user_id')->select('id','username','email');
    }

    // added !!!
    public function categories() {
        return $this->belongsTo('Category','category_id')->select('name','name_en','type','slug');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * get the followers of the Event
     * @param int eventId
     */
    public function followers() {
//        return $this->hasMany('Follower','event_id');
        $followers = $this->belongsToMany('User', 'followers','event_id','user_id')->select('username','email');
        return $followers;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * get the subscribers for the Event
     * @param int eventId
     */
    public function subscriptions() {
        return $this->belongsToMany('User', 'subscriptions','event_id','user_id');
//        return $this->hasMany('Subscription','event_id');
    }
    public function subscribers() {
        return $this->belongsToMany('User', 'subscriptions','event_id','user_id');
//        return $this->hasMany('Subscription','event_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @param int eventId
     * get the favorites user of the Event
     */
    public function favorites() {
//        return $this->hasMany('Favorite','event_id');
        return $this->belongsToMany('User', 'favorites','event_id','user_id');

    }

    /**
     * gets the past events
     */
    public function getPastEvents(){
        return DB::table('events AS e')
            ->join('photos AS p', 'e.id', '=', 'p.imageable_id', 'LEFT')
            ->where('p.imageable_type', '=', 'EventModel')
            ->where('e.date_start','<',Carbon::now()->toDateTimeString());
    }

    /**
     * @param int $days
     * @return \Illuminate\Database\Query\Builder|static
     * get Recent Event by Days
     */
    public static  function getRecentEvents($days) {
        $dt = Carbon::now()->addDays($days);
        return DB::table('events AS e')
            ->join('photos AS p', 'e.id', '=', 'p.imageable_id', 'LEFT')
            ->where('p.imageable_type', '=', 'EventModel')
            ->where('e.date_start','<',$dt->toDateTimeString());
    }

    public function getRelatedEvents() {

    }

    public function category() {
//        return $this->morphMany('Category','categorizable','categorizable_type');
        return $this->belongsTo('Category','category_id');
    }

    public function  location() {
        return $this->belongsTo('Location');
    }

    /*
     * @todo fix the query
     * this method can be eager loaded as nested relationship, ex;location.query and
     * can be accessed in view as location->country->name
     *
     */
    public function country() {
//        return $this->hasManyThrough('Country','Location','country_id','id');
//        return $this->location()->country;

    }

    /**
     * Return all the categories for Event
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     *
     */
//    public function categories() {
//        return $this->hasMany('Category'); // where
//    }


    public function photos() {
        return $this->morphMany('Photo','imageable');
    }

    /**
     * Fetches posts for latest Event
     * @return array
     *
     */
    public  function latestEvents()
    {
        return DB::table('events as e')
            ->join('photos as p', 'e.id', '=', 'p.imageable_id', 'LEFT')
            ->where('p.imageable_type', '=', 'EventModel')
            ->where('e.date_start','>',Carbon::now()->toDateTimeString())
            ->orderBy('e.date_start','DESC')
            ->orderBy('e.created_at','DESC')
            ->take('5')
            ->get(array('e.id'))
            ;
    }

    /**
     * Fetches posts for latest Event
     * @return array
     *
     */
    public  function feautredEvents()
    {
        return DB::table('events AS e')
            ->join('photos AS p', 'e.id', '=', 'p.imageable_id', 'LEFT')
            ->where('p.imageable_type', '=', 'EventModel')
            ->where('e.date_start','>',Carbon::now()->toDateTimeString())
            ->where('e.featured','1')
            ->orderBy('e.date_start','DESC')
            ->orderBy('e.created_at','DESC')
            ->take('5')
            ->get(array('e.id'))
            ;
    }

    public function getSliderEvents($limit, $array) {
        $events = DB::table('events AS e')
            ->join('photos AS p', 'e.id', '=', 'p.imageable_id', 'LEFT')
            ->whereIn('e.id',$array)
            ->take($limit)
            ->groupBy('e.id')
            ->get(array('e.id','e.title','e.title_en','e.description','e.description_en','p.name','e.button','e.button_en'));
        return $events;
    }

    public static  function fixEventCounts($id,$count) {
        $event = EventModel::find($id);
        $event->available_seats = $event->total_seats - $count;
        $event->save();
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

    public static function latest($count) {
        return EventModel::orderBy('created_at', 'DESC')->select('id','title','slug','title_en')->remember(10)->limit($count)->get();
    }

    protected function getHumanTimestampAttribute($column)
    {
        if ($this->attributes[$column])
        {
            return Carbon::parse($this->attributes[$column])->diffForHumans();
        }

        return null;
    }
//
//    public function getDates() {
//        return array('created_at','updated_at','date_start','date_end');
//    }
    public function getDates()
    {
        return array_merge(array(static::CREATED_AT, static::UPDATED_AT, static::DELETED_AT), array('date_start','date_end'));
    }

    public function setDateStartAttribute($value)
    {
        $this->attributes['date_start'] = $this->dateStringToCarbon($value);
    }

    public function setDateEndAttribute($value)
    {
        $this->attributes['date_end'] = $this->dateStringToCarbon($value);
    }

}

