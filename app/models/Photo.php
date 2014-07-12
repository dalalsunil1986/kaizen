<?php

class Photo extends BaseModel {

    protected $guarded = array('id');

    protected $name = "photo";

    protected $table = "photos";

    public function imageable()
    {
        return $this->morphTo();
    }

}
