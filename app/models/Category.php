<?php

class Category extends BaseModel {
	protected $guarded = array();
    protected  $table = "categories";

    public static $rules = array(
        'name' => 'required',
        'type' => 'required'
    );



}
