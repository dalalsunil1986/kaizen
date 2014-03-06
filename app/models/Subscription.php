<?php
use Auth;
class Subscription extends BaseModel {
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
     * @return boolean
     * Is User subsribed to this event
     */
    public static function isSubscribed($id) {
        $user = Auth::user();
        $query = Subscription::where('user_id', '=', $user->id)->where('event_id', '=', $id)->count();
        return ($query >= 1 ) ? true : false;
    }

    /**
     * @param $id eventId
     * @return boolean true
     * Unsubscribe User
     */
    public static function unsubscribe($id) {
        $user = Auth::user();
        $query = Subscription::where('user_id','=',$user->id)->where('event_id','=',$id)->delete();
        return $query ? true : false;
    }
}
