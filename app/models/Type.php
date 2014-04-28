<?php

class Type extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array(
        'user_id' => 'required | integer',
        'event_id' => 'required | integer'
    );

    public  function users() {
        return $this->belongsTo('User');
    }

    public  function events() {
        return $this->belongsToMany('EventModel');
    }

    /**
     * @param $id eventId
     * @param $userId int
     * @return boolean
     * Is User subsribed to this event
     */
    public static function isSubscribed($id,$userId) {
        $query = Subscription::where('user_id', '=', $userId)->where('event_id', '=', $id)->count();
        return ($query >= 1 ) ? true : false;
    }

    /**
     * @param $id eventId
     * @param $userId int
     * @return boolean true
     * Unsubscribe User
     */
    public static function unsubscribe($id,$userId) {
        $query = Subscription::where('user_id','=',$userId)->where('event_id','=',$id)->delete();
        return $query ? true : false;
    }

    public static function findEventCount($id) {
        $query = Subscription::where('event_id',$id)->count();
        return $query;
    }
}
