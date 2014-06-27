<?php namespace Acme\Contact\Validators;

use Acme\Core\Validators\AbstractValidator;

class ContactCreateValidator extends AbstractValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'email'=>'required|email',
        'name'=>'required',
        'comment'=>'required|min:5'
    );

}
