<?php

class Category extends BaseModel {
	protected $guarded = array();
    protected  $table = "categories";

    public static $rules = array(
        'name' => 'required',
        'type' => 'required'
    );

    public static function getEventCategories() {
        //get_all categories for events
//        return $this->morphedByMany('EventModel','Post');
//        return $this->morphedByMany('EventModel','categorizable','categories','id');
        return DB::table('categories')->where('type','=', 'EventModel');
    }
    public static function getPostCategories() {
//        return $this->morphedByMany('EventModel','Post');
//        return $this->morphedByMany('EventModel','categorizable','categories','id');
//        return $this->hasMany('Post');
        return DB::table('categories')->where('type','=', 'Post');
    }

    public function type() {
        return $this->type();
    }

}
