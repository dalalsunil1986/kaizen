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

}