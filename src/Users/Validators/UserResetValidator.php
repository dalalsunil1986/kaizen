<?php namespace Acme\Users\Validators;

use Acme\Core\Validators\Validable;
use Acme\Core\Validators\LaravelValidator;

class UserResetValidator extends LaravelValidator implements Validable {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'email'    => 'required|email',
    );

}
