<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Subscription extends BaseModel {

    use SoftDeletingTrait;

    protected $guarded = array('id');

    protected static $name = 'subscription';

    protected $dates = ['deleted_at'];

    public static $rules = array(
        'user_id'  => 'required | integer',
        'event_id' => 'required | integer'
    );

    protected $with = ['user'];

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

    public function payments()
    {
        return $this->morphMany('Payment', 'payable');
    }

    /**
     * @return mixed
     * Check If a User Has Confirmed The Payment
     */
    public function paymentSuccess()
    {
        $query = $this->morphOne('Payment', 'payable')->where('user_id', Auth::user()->id)->where('status','CONFIRMED');
        return $query;
    }

}
