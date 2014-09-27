<?php namespace Acme\Tag\Validators;

use Acme\Core\Validators\AbstractValidator;

class CreateValidator extends AbstractValidator {

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
