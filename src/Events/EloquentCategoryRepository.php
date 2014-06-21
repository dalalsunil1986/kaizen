<?php namespace Acme\Events;

use Acme\Users\UserRepository;
use Category;
use DB;
use Illuminate\Support\MessageBag;
use Acme\Core\Repositories\Crudable;
use Acme\Core\Repositories\Illuminate;
use Acme\Core\Repositories\Paginable;
use Acme\Core\Repositories\Repository;
use Acme\Core\Repositories\AbstractRepository;

class EloquentCategoryRepository extends AbstractRepository implements Repository, Paginable, Crudable, UserRepository {

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * Construct
     *
     * @param \Illuminate\Database\Eloquent\Model $model
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


    public static function getEventCategories() {
        //get_all categories for events
//        return $this->morphedByMany('EventModel','Post');
//        return $this->morphedByMany('EventModel','categorizable','categories','id');
        return DB::table('categories')->where('type','=', 'EventModel');
    }
    public static function getPostCategories() {
//        return $this->morphedByMany('EventModel','Post');
//        return $this->morphedByMany('EventModel','categorizable','categories','id');
//        return $this->hasMany('Post');
        return DB::table('categories')->where('type','=', 'Post');
    }

    public function type() {
        return $this->type();
    }

}