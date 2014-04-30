<?php


class Location extends BaseModel {
	protected $guarded = array('');
	public static $rules = array(
        'name' => 'required | unique:locations,name,:id',
        'country_id' => 'required | integer'
    );

    public static  function boot() {
        parent::boot();
    }

    public function country() {
        return $this->belongsTo('Country');
    }

    public function events() {
        return $this->hasMany('EventModel');
    }
}
