<?php namespace Acme\Category\Validators;

use Acme\Core\Validators\AbstractValidator;

class UpdateValidator extends AbstractValidator {

    protected $rules = array(
        'name_ar'       => 'required',
        'type'          => 'required'
    );

    public function getInputData()
    {
        return array_only($this->inputData, [
            'name_ar','name_en','type'
        ]);
    }
}

