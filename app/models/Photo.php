<?php

class Photo extends BaseModel {

    protected $guarded = array('id');

    protected static  $name = "photo";

    protected $table = "photos";

    public function imageable()
    {
        return $this->morphTo();
    }

}
