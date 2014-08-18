<?php namespace Acme\Comment;

use Acme\Core\CrudableTrait;
use Comment;
use Illuminate\Support\MessageBag;
use Acme\Core\Repositories\Crudable;
use Acme\Core\Repositories\Illuminate;

use Acme\Core\Repositories\AbstractRepository;

class CommentRepository extends AbstractRepository  {

    use CrudableTrait;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * Construct
     *
     * @param \Category|\Illuminate\Database\Eloquent\Model $model
     * @internal param \Illuminate\Database\Eloquent\Model $user
     */
    public function __construct(Comment $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

    public function getEventCategories() {
        return $this->model->where('type','=', 'EventModel');
    }
    public function getPostCategories() {
        return $this->model->where('type','=', 'Post');
    }

    public function type() {
        return $this->type();
    }

}