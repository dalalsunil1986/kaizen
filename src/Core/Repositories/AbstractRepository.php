<?php namespace Acme\Core\Repositories;

use Illuminate\Database\Eloquent\Model;
use StdClass;
use Illuminate\Support\MessageBag;

abstract class AbstractRepository {

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * Construct
     *
     * @param \Illuminate\Support\MessageBag $errors
     */
    public function __construct(MessageBag $errors)
    {
        $this->errors = $errors;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getAllPaginated($count)
    {
        return $this->model->paginate($count);
    }

    public function getById($id, array $with = [] )
    {
        if (isset($with) && (!empty($with))) {

            return $this->model->with($with)->find($id);
        }

        return $this->model->find($id);
    }

    public function requireById($id, array $with = [])
    {
        $model = $this->getById($id, $with);

        if ( ! $model) {
            throw new EntityNotFoundException;
        }

        return $model;
    }

    public function getNew($attributes = array())
    {
        return $this->model->newInstance($attributes);
    }

    /**
     * Make a new instance of the entity to query on
     *
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function make(array $with = array())
    {
        return $this->model->with($with);
    }

    /**
     * Register Validators
     *
     * @param string $name
     * @param Validible $validator
     */
    public function registerValidator($name, $validator)
    {
        $this->validators[$name] = $validator;
    }

    /**
     * Check to see if the input data is valid
     *
     * @param $name
     * @param array $data
     * @return boolean
     */
    public function isValid($name, array $data)
    {
        if( $this->validators[$name]->with($data)->passes() )
        {
            return true;
        }

        $this->errors = $this->validators[$name]->errors();
        return false;
    }

    /**
     * Get Results by Page
     *
     * @param int $page
     * @param int $limit
     * @param array $with
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function getByPage($page = 1, $limit = 10, $with = array())
    {
        $result             = new StdClass;
        $result->page       = $page;
        $result->limit      = $limit;
        $result->totalItems = 0;
        $result->items      = array();

        $query = $this->make($with);

        $users = $query->skip($limit * ($page - 1))
            ->take($limit)
            ->get();

        $result->totalItems = $this->model->count();
        $result->items      = $users->all();

        return $result;
    }

    /**
     * Search for many results by key and value
     *
     * @param string $key
     * @param mixed $value
     * @param array $with
     * @return \Illuminate\Database\Query\Builders
     */
    public function getBy($key, $value, array $with = [])
    {
        return $this->make($with)->where($key, '=', $value)->get();
    }

    /**
     * Return the errors
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Set error message bag
     *
     * @var \Illuminate\Support\MessageBag
     * @return \Illuminate\Support\MessageBag
     */
    public function addError($errorMsg)
    {
        //@todo enhance snake_case to remove spaces
        $key = snake_case($errorMsg);
        return $this->errors->add($key,$errorMsg);
    }

    protected function storeEloquentModel($model)
    {
        if ($model->getDirty()) {
            return $model->save();
        } else {
            return $model->touch();
        }
    }

    protected function storeArray($data)
    {
        $model = $this->getNew($data);
        return $this->storeEloquentModel($model);
    }

    public function save(Model $model)
    {
        if ($model->getDirty()) {
            return $model->save();
        } else {
            return $model->touch();
        }
    }
}
