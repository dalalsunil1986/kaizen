<?php

class Contact extends BaseModel {
	protected $fillable = [];
    protected $table = 'contacts';

    public static $rules= [
        'email'=>'required|email',
        'username'=>'required',
        'mobile' => 'integer',
        'phone' =>'integer',
        'mobile'=>'integer'
    ];

}