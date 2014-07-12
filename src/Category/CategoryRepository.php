<?php namespace Acme\Category;

use Category;
use Illuminate\Support\MessageBag;
use Acme\Core\Repositories\Crudable;
use Acme\Core\Repositories\Illuminate;

use Acme\Core\Repositories\AbstractRepository;

class CategoryRepository extends AbstractRepository  {

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
    public function __construct(Category $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

    /**
     * Create a new entity
     *
     * @param array $input
     * @internal param array $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create(array $input)
    {
        return $this->model->create($input);
    }

    /**
     * Update an existing entity
     *
     * @param array $input
     * @internal param array $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function update(array $input)
    {
        // TODO: Implement update() method.
    }

    /**
     * Delete an existing entity
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
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