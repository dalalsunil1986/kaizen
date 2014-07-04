<?php

use Carbon\Carbon;

class EventModel extends BaseModel implements \McCool\LaravelAutoPresenter\PresenterInterface {

	protected $guarded = ['id'];

    protected  $table = "events";

    protected $name = "event";

    public static $rules = array(
        'title_ar'=>'required',
        'description_ar'=>'required',
        'user_id' => 'required',
        'category_id' => 'required',
        'location_id' =>'required'
    );

    public function comments() {
        return $this->morphMany('Comment','commentable');
    }

    public function user() {
        return $this->belongsTo('User');
    }

    public function author() {
        return $this->belongsTo('User','user_id')->select('id','username','email');
    }

    public function categories() {
        return $this->belongsTo('Category','category_id')->select('name','name_en','type','slug');
    }

    public function followers() {
        $followers = $this->belongsToMany('User', 'followers','event_id','user_id')->select('username','email');
        return $followers;
    }

    public function subscriptions() {
        return $this->belongsToMany('User', 'subscriptions','event_id','user_id');
    }
    public function subscribers() {
        return $this->belongsToMany('User', 'subscriptions','event_id','user_id');
    }

    public function favorites() {
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
        return $this->belongsTo('Category','category_id');
    }

    public function  location() {
        return $this->belongsTo('Location');
    }

    public function photos() {
        return $this->morphMany('Photo','imageable');
    }

    // @todo : replace this func
    public static  function fixEventCounts($id,$count) {
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

    public static function latest($count) {
//        return EventModel::orderBy('created_at', 'DESC')->select('id','title','slug','title_en')->remember(10)->limit($count)->get();
    }



    public function getDates()
    {
        return array_merge(array(static::CREATED_AT, static::UPDATED_AT), array('date_start','date_end'));
    }

    public function setDateStartAttribute($value)
    {
        $this->attributes['date_start'] = $this->dateStringToCarbon($value);
    }

    public function setDateEndAttribute($value)
    {
        $this->attributes['date_end'] = $this->dateStringToCarbon($value);
    }

    public function type() {
        return $this->hasOne('Type','event_id');
    }

    public function statuses() {
        return $this->belongsToMany('User', 'statuses','event_id','user_id')->withPivot(array('id','event_id','user_id','status'));
//        return $this->hasMany('Subscription','event_id');
    }

    public function updateSeats()
    {
        $totalSeats = $this->total_seats;
        if ($totalSeats > 0 ) {
            $totalSubscriptions = $this->subscriptions->count();
            $this->available_seats = $totalSeats - $totalSubscriptions;
            $this->save();
            return $this;
        }
    }

    /**
     * Get the presenter class.
     *
     * @return string The class path to the presenter.
     */
    public function getPresenter()
    {
        return 'Acme\Events\EventPresenter';
    }

    protected function getHumanCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();

        return null;
    }


}

