<?php

class Contact extends \Eloquent {
	protected $fillable = [];
    protected $table = 'contacts';

    public $rules= [
        'email'=>'required|email',
        'username'=>'required',
        'mobile' => 'int',
        'phone' =>'int'
    ];

}