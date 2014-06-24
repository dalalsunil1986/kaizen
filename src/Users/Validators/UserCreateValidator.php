<?php namespace Acme\Users\Validators;

use Acme\Core\Validators\Validable;
use Acme\Core\Validators\LaravelValidator;

class UserCreateValidator extends LaravelValidator implements Validable {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|alpha_num|between:6,12|confirmed',
        'name_ar'  => 'required',
        'name_en'  => 'required',
        'phone'    => 'required',
    );

}
