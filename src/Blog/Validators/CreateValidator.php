<?php namespace Acme\Blog\Validators;

use Acme\Core\Validators\AbstractValidator;

class CreateValidator extends AbstractValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'title_ar'       => 'required',
        'description_ar' => 'required',
        'user_id'        => 'required',
        'category_id'    => 'required',
    );

    public function getInputData()
    {
        return array_only($this->inputData, [
            'user_id', 'category_id', 'title_ar','title_en','description_ar','description_en'
        ]);
    }
}
