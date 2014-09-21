<?php namespace Acme\User\Validators;

use Acme\Core\Validators\AbstractValidator;
use Auth;
use User;

class AdminCreateValidator extends AbstractValidator {

    /**
     * Validation rules
     *
     * @var array
     */

    protected $rules = array(
        'phone'    => 'sometimes',
        'mobile'   => 'required|sometimes',
        'username' => 'required|unique:users,username',
        'email'    => 'required|email|unique:users,email,:id',
        'password' => 'required|alpha_num|between:6,12|confirmed',
        'name_ar'  => 'required',
        'name_en'  => 'required',
    );

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'name_ar', 'name_en', 'password', 'password_confirmation', 'country_id', 'twitter', 'phone', 'mobile','active','username','email'
        ]);
    }

    /**
     * Remove Password field if empty
     */
    public function beforeValidation()
    {
//        if ( empty($this->inputData['password']) )
//            unset($this->inputData['password']);
//
//        {
//            $user = User::find($this->inputData['user_id']);
//            $user->email = $this->inputData['email'];
//            $user->username = $this->inputData['username'];
//
//            if ( ! $user->isDirty('email') ) {
//                unset($this->inputData['email']);
//            }
//            if ( ! $user->isDirty('username') ) {
//                unset($this->inputData['username']);
//            }
//
//        }
    }


}
