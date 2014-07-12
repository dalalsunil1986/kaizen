<?php namespace Acme\Contact;

use Acme\Contact\Validators\ContactCreateValidator;
use Acme\Core\CrudableTrait;
use Contact;
use Illuminate\Support\MessageBag;
use Acme\Core\Repositories\Illuminate;
use Acme\Core\Repositories\AbstractRepository;

class ContactRepository extends AbstractRepository {

    use CrudableTrait;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * Construct
     *
     * @param \Country|\Illuminate\Database\Eloquent\Model $model
     * @internal param \Illuminate\Database\Eloquent\Model $user
     */
    public function __construct(Contact $model)
    {
        $this->model = $model;
        parent::__construct(new MessageBag);
    }

    public function getContactForm() {
        return new ContactCreateValidator();
    }

}