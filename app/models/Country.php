<?php

class Country extends BaseModel {
	protected $guarded = array();

	public static $rules = array();

    public function locations() {
        return $this->hasMany('Location');
    }
}
