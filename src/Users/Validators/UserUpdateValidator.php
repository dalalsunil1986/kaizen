<?php namespace Acme\Users\Validators;

use Acme\Core\Validators\Validable;
use Acme\Core\Validators\LaravelValidator;

class UserUpdateValidator extends LaravelValidator implements Validable {

    /**
     * Validation rules
     *
     * @var array
     */

    protected $rules = array(
        'email' => 'email|unique:users,email,{id}',
        'password' => 'alpha_num|between:6,12|confirmed',
    );

}
