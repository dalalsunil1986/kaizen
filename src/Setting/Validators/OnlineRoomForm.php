<?php namespace Acme\Setting\Validators;

use Acme\Core\Validators\AbstractValidator;

class OnlineRoomForm extends AbstractValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'online_room_no' => 'required | integer'
    );

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'online_room_no'
        ]);
    }

}
