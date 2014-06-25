<?php namespace Acme\Users\Validators;

use Acme\Core\Validators\AbstractValidator;

class UserUpdateValidator extends AbstractValidator{

    /**
     * Validation rules
     *
     * @var array
     */

    protected $rules = array(
        'password' => 'alpha_num|between:6,12|confirmed',
        'phone' => 'numeric',
        'mobile' => 'numeric',
        'name_en' => 'alpha_num|between:3,40',
        'name_ar' => 'between:3,40',
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
