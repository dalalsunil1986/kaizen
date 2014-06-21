<?php
namespace Acme\Core;

trait CrudableTrait {

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

} 