<?php

class Photo extends BaseModel {
	protected $guarded = array();

	public static $rules = array();

    public function imageable()
    {
        return $this->morphTo();
    }
}
