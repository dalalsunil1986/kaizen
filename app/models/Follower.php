<?php

class Follower extends BaseModel {
    protected $guarded = array();

    public static $rules = array(
        'user_id' => 'required | integer',
        'event_id' => 'required | integer'
    );

    public function users() {
        return $this->belongsTo('User');
    }

    public  function events() {
        return $this->belongsTo('EventModel');
    }

    /**
     * @param $id eventId
     * @param $userId
     * @return boolean
     */
    public static function isFollowing($id,$userId) {
        $query = Follower::where('user_id', '=', $userId)->where('event_id', '=', $id)->count();
        return ($query >= 1 ) ? true : false;
    }

    /**
     *
     * @param $id eventId
     * @param $userId
     * @return boolean true
     * Unfollow User
     */
    public static function unfollow($id,$userId) {
        $query = Follower::where('user_id','=',$userId)->where('event_id','=',$id)->delete();
        return $query ? true : false;
    }
}

