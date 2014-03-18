<?php

class Contact extends \Eloquent {
	protected $fillable = [];
    protected $table = 'contacts';

    public $rules= [
        'email'=>'required|email',
        'comment'=>'required|min:3',
        'mobile' => 'int',
        'phone' =>'int'
    ];

}