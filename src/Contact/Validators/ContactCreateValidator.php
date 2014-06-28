<?php namespace Acme\Contact\Validators;

use Acme\Core\Validators\AbstractValidator;

class ContactCreateValidator extends AbstractValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'sender_email'=>'required|email',
        'sender_name'=>'required',
        'body' => 'required|min:5'
    );

}
