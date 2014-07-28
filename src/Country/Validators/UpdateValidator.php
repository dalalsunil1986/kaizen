<?php namespace Acme\Country\Validators;

use Acme\Core\Validators\AbstractValidator;

class UpdateValidator extends AbstractValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'name_ar'       => 'required',
    );

    public function getInputData()
    {
        return array_only($this->inputData, [
            'name_ar','name_en'
        ]);
    }
}

