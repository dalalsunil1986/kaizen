<?php namespace Acme\Setting\Validators;

use Acme\Core\Validators\AbstractValidator;

class UpdateValidator extends AbstractValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'approval_type'=>'required',
        'registration_types'=>'sometimes | array',
        'vip_price' => 'integer',
        'online_price' => 'integer',
    );

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'approval_type','registration_types','vip_description_en','vip_description_ar','online_description_en','online_description_ar','vip_price','online_price'
        ]);
    }

}
