<?php

class Ad extends \Eloquent {
	protected $fillable = [];

    protected $table="photos";

    public static function getAd1() {
        $image = DB::table('photos')->where('imageable_id',1)->where('imageable_type','Ad')->remember(60)->pluck('name');
        return $image;
    }

    public static function getAd2() {
        $image = DB::table('photos')->where('imageable_id',2)->where('imageable_type','Ad')->remember(60)->pluck('name');
        return $image;
    }

}