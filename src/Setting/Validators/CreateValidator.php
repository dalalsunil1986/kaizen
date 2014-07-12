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
            'user_id', 'category_id', 'location_id', 'title_ar', 'title_en', 'description_ar', 'description_en', 'total_seats', 'free' , 'price', 'date_start', 'date_end', 'address_ar', 'street_ar', 'address_en', 'street_en', 'phone', 'email', 'latitude', 'longitude', 'button_ar', 'button_en'
        ]);
    }

}
