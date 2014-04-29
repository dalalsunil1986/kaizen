<?php

class Type extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array(
        'event_id' => 'required | integer',
        'type' =>'required',
        'approval_type' => 'required'
    );

    public  function events() {
        return $this->belongsTo('EventModel');
    }

}
