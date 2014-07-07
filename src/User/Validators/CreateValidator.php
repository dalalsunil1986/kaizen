<?php namespace Acme\User\Validators;

use Acme\Core\Validators\AbstractValidator;

class UserCreateValidator extends AbstractValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|alpha_num|between:6,12|confirmed',
        'name_ar'  => 'required|between:3,40',
        'name_en'  => 'required|alpha|between:3,40',
        'mobile'   => 'required|numeric',
        'username' => 'required|alpha_num|between:3,40',
    );

}
