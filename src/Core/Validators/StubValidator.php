<?php
namespace Kuwaitii\Core\Validators;


class StubValidator extends LaravelValidator implements Validable {

    /**
     * Validation for creating a new User
     *
     * @var array
     */
    protected $rules = array(
        'username' => 'required|min:2',
        'email' => 'required|email',
        'password' => 'required'
    );

}