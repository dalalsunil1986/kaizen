<?php

class EventModel extends BaseModel {
	protected $guarded = array();

	public static $rules = array(
        'title'=>'required',
        'description'=>'required'
    );

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


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * get the followers of the Event
     * @param int eventId
     */
    public function followers() {
//        return $this->hasMany('Follower','event_id');
        $followers = $this->belongsToMany('User', 'followers','event_id','user_id')->withTimestamps();
        return $followers;

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * get the subscribers for the Event
     * @param int eventId
     */
    public function subscriptions() {
        return $this->belongsToMany('User', 'subscriptions','event_id','user_id')->withTimestamps();
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
        return $this->belongsToMany('User', 'favorites','event_id','user_id')->withTimestamps();

    }

    /**
     * gets the past events
     */
    public function getPastEvents(){

    }

    public function getRecentEvents() {

    }

    public function getRelatedEvents() {

    }

    public function category() {
//        return $this->morphMany('Category','categorizable','categorizable_type');
        return $this->belongsTo('Category','category_id');
    }

    public function  Location() {
        return $this->belongsTo('Location');
    }

    /*
     * @todo fix the query
     *
     */
    public function country(){
        return $this->BelongsToThrough('Country','Location','country_id','id');
    }

//    public function categories() {
//        return $this->hasMany('Category'); // where
//    }


    public function photos() {
        return $this->morphMany('Photo','imageable');
    }

    public static function featured($limit = 5)
    {
        return DB::table('events AS e')
            ->join('photos AS p', 'e.id', '=', 'p.imageable_id', 'LEFT')
            ->where('p.imageable_type', '=', 'EventModel')
            ->take($limit);
//            ->get(array('e.id', 'e.title', 'e.description', 'p.name'));

//        return DB::table("events as e")->select("e.id,e.title")->join("photos as p", function($join) {
//            $join->on("e.id", "=", "p.imageable_id")
//                ->where("p.imageable_type", "=", 'EventModel');
//        });

    }
}

