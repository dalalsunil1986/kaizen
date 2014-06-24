<?php

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

    /**
     * Create a new model.
     *
     * @param  array $input
     * @throws Exception
     * @return mixed
     */
    public static  function create(array $input)
    {
        DB::beginTransaction();

        try {
            Event::fire(static::$name . '.creating', array($input));
            static::beforeCreate($input);
            $return = parent::create($input);
            static::afterCreate($input, $return);
            Event::fire(static::$name . '.created', array($input));

            DB::commit();
        }
        catch ( \Exception $e ) {
            DB::rollBack();
            throw $e;
        }

        return $return;
    }

    /**
     * Before creating a new model.
     *
     * @param  array $input
     * @return mixed
     */
    public static function beforeCreate(array $input)
    {
        // can be overwritten by extending class
    }

    /**
     * After creating a new model.
     *
     * @param  array $input
     * @param  mixed $return
     * @return mixed
     */
    public static function afterCreate(array $input, $return)
    {
        // can be overwritten by extending class
    }

    /**
     * Update an existing model.
     *
     * @param  array $input
     * @throws Exception
     * @return mixed
     */
    public function update(array $input = [])
    {
        DB::beginTransaction();

        try {
            Event::fire(static::$name . '.updating', array($input));
            $this->beforeUpdate($input);
            $return = parent::update($input);
            $this->afterUpdate($input, $return);
            Event::fire(static::$name . '.updated', array($input));

            DB::commit();
        }
        catch ( \Exception $e ) {
            DB::rollBack();
            throw $e;
        }

        return $return;
    }

    /**
     * Before updating an existing new model.
     *
     * @param  array $input
     * @return mixed
     */
    public function beforeUpdate(array $input)
    {
        // can be overwritten by extending class
    }

    /**
     * After updating an existing model.
     *
     * @param  array $input
     * @param  mixed $return
     * @return mixed
     */
    public function afterUpdate(array $input, $return)
    {
        // can be overwritten by extending class
    }

    /**
     * Delete an existing model.
     *
     * @return mixed
     */
    public function delete()
    {
        DB::beginTransaction();

        try {
            Event::fire(static::$name . '.deleting', $this);
            $this->beforeDelete();
            $return = parent::delete();
            $this->afterDelete($return);
            Event::fire(static::$name . '.deleted', $this);

            DB::commit();
        }
        catch ( \Exception $e ) {
            DB::rollBack();
            throw $e;
        }

        return $return;
    }

    /**
     * Before deleting an existing model.
     *
     * @return mixed
     */
    public function beforeDelete()
    {
        // can be overwritten by extending class
    }

    /**
     * After deleting an existing model.
     *
     * @param  mixed $return
     * @return mixed
     */
    public function afterDelete($return)
    {
        // can be overwritten by extending class
    }

}
?>