<?php

class Ad extends BaseModel {
	protected $fillable = [];

    protected $table="photos";

    public static $rules = [

    ];

    protected static function boot()
    {
        parent::boot();
        static::saved(function($model)
        {
            Cache::forget('cache.ad1');
            Cache::forget('cache.ad2');
        });
    }


    public static function getAd1() {
        $image = DB::table('photos')->where('imageable_id',1)->where('imageable_type','Ad')->remember(60,'cache.ad1')->pluck('name');
        return $image;
    }

    public static function getAd2() {
        $image = DB::table('photos')->where('imageable_id',2)->where('imageable_type','Ad')->remember(60,'cache.ad2')->pluck('name');
        return $image;
    }

}