<?php namespace Acme\Users\Validators;

use Acme\Core\AbstractForm;

class UserUpdateValidator extends AbstractForm{

    /**
     * Validation rules
     *
     * @var array
     */

    protected $rules = array(
        'email' => 'email|unique:users,email,{id}',
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
            'name_ar', 'name_en', 'password', 'country_id', 'twitter', 'phone', 'mobile'
        ]);
    }

}
