<?php

class Subscription extends BaseModel {

    protected $guarded = array('id');

    // Afdal :: so weird property ?? !! never used within the class itself !!!!
    // do you mean to define $table ? !!!! please clarify
    protected static $name = 'subscription';

    public static $rules = array(
        'user_id'  => 'required | integer',
        'event_id' => 'required | integer'
    );

    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function event()
    {
        return $this->belongsTo('EventModel', 'event_id');
    }

    public function totalSubscriptions()
    {
        // return count of total subscriptions
    }

    public function settings()
    {
        return $this->hasManyThrough('Setting','EventModel','id','settingable_id');
    }

    /**
     * If the User already confirmed
     */
    public function subscriptionConfirmed()
    {
        return $this->status == 'CONFIRMED' ? true : false;
    }

    public function scopeOfStatus($query, $status)
    {
        return $query->whereStatus($status);
    }

}
