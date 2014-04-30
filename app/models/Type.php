<?php

class Type extends BaseModel {
	protected $guarded = array('id');

	public static $rules = array(
        'type' =>'required',
        'approval_type' => 'required'
    );

    public  function events() {
        return $this->belongsTo('EventModel');
    }

}
