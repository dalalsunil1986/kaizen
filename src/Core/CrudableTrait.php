<?php
namespace Acme\Core;

trait CrudableTrait {

    /**
     * Create a new entity
     *
     * @param array $input
     * @internal param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $input)
    {
        return $this->model->create($input);
    }

    /**
     * Update an existing entity
     *
     * @param $id
     * @param array $input
     * @internal param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $input)
    {
        $record = $this->requireById($id);

        $record->fill($input);

        if ( $this->save($record) ) return true;

        $this->addError('Could Not Update');

        return false;
    }

    /**
     * Delete an existing entity
     *
     * @param Model $model
     * @internal param int $id
     * @return boolean
     */
    public function delete(Model $model)
    {
        return $model->delete();
    }

} 