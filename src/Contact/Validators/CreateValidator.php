<?php namespace Acme\Contact\Validators;

use Acme\Core\Validators\AbstractValidator;

class CreateValidator extends AbstractValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'name_ar' => 'required',
        'address_ar' => 'required',
        'email' => 'required',
        'mobile' => 'required',
        'phone' => 'required'
    );

}
