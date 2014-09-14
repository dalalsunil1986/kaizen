<?php namespace Acme\User\Validators;

use Acme\Core\Validators\AbstractValidator;

class ResetValidator extends AbstractValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'email'    => 'required|email',
    );

}
