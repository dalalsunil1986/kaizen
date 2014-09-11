<?php namespace Acme\Contact;

use Acme\Contact\Validators\ContactCreateValidator;
use Acme\Contact\Validators\ContactValidator;
use Acme\Core\CrudableTrait;
use Acme\Core\Repositories\AbstractRepository;
use Acme\Core\Repositories\Illuminate;
use Contact;
use Illuminate\Support\MessageBag;

class ContactRepository extends AbstractRepository {

    use CrudableTrait;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * Construct
     *
     * @param \Contact|\Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Contact $model)
    {
        $this->model = $model;
        parent::__construct(new MessageBag);
    }

    public function getContactForm() {
        return new ContactValidator();
    }

}