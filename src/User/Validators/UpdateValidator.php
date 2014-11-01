<?php namespace Acme\User\Validators;

use Acme\Core\Validators\AbstractValidator;

class UpdateValidator extends AbstractValidator {

    /**
     * Validation rules
     *
     * @var array
     */

    protected $rules = array(
        'phone'    => 'numeric',
        'mobile'   => 'required|numeric',
        'name_en'  => 'required|alpha_num|between:3,40',
        'name_ar'  => 'required|between:3,40',
        'password' => 'alpha_num|between:6,12|confirmed',
    );

    public function __construct($id)
    {
        parent::__construct();

        $this->id = $id;
    }

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'name_ar', 'name_en', 'password', 'password_confirmation', 'country_id', 'twitter', 'phone', 'mobile','gender','instagram'
        ]);
    }

    /**
     * Remove Password field if empty
     */
    public function beforeValidation()
    {
        if ( empty($this->inputData['password']) )
            unset($this->inputData['password']);

    }


}
