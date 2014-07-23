<?php namespace Acme\Setting\Validators;

use Acme\Core\Validators\AbstractValidator;
use Acme\Event\EventRepository;

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
        'approval_type'=>'required|array',
    ];

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'approval_type','registration_types'
        ]);
    }

}
