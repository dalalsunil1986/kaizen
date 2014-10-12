<?php

class Photo extends BaseModel {

    protected $guarded = array('id');

    protected static  $name = "photo";

    protected $table = "photos";

    protected static function boot()
    {
        static::saved(function($model)
        {
            if($model->imageable_type=='Ad') {
                Cache::forget('cache.ad1');
                Cache::forget('cache.ad2');
            }
        });
        parent::boot();
    }

    public function imageable()
    {
        return $this->morphTo();
    }

}
