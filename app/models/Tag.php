<?php

class Tag extends \Eloquent {
	protected $fillable = [];
    protected $table = 'tags';

    // a Tag has many Events
    // an event has many tags ===>
    public function events () {
        return $this->belongsToMany('EventModel', 'event_tag' , 'event_id' , 'tag_id');
    }

}