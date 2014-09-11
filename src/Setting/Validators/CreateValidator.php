<?php namespace Acme\Setting\Validators;

use Acme\Core\Validators\AbstractValidator;
use Acme\EventModel\EventRepository;

class CreateValidator extends AbstractValidator {

    protected  $eventRepository;
    public function __constrcut(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
        parent::__construct();
    }

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = [
        'approval_type'=>'required',
        'vip_price' => 'integer',
        'online_price' => 'integer',
    ];

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
