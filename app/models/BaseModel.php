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
    public static function beforeCreate(array $input) {}

    /**
     * After creating a new model.
     *
     * @param  array $input
     * @param  mixed $return
     * @return mixed
     */
    public static function afterCreate(array $input, $return) {}

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
    public function beforeUpdate(array $input) {}

    /**
     * After updating an existing model.
     *
     * @param  array $input
     * @param  mixed $return
     * @return mixed
     */
    public function afterUpdate(array $input, $return) {}

    /**
     * Delete an existing model.
     *
     * @throws Exception
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
    public function beforeDelete() {}

    /**
     * After deleting an existing model.
     *
     * @param  mixed $return
     * @return mixed
     */
    public function afterDelete($return) {}

    /**
     * @param $value
     * Set Phone Attribute to Integer
     * Match Type Case with database column type
     */
    public function setPhoneAttribute($value){
        $this->attributes['phone'] = (int)($value);
    }

    /**
     * @param $value
     * Set Mobile Attribute to Integer
     * Match Type Case with database column type
     */
    public function setMobileAttribute($value){
        $this->attributes['mobile'] = (int)($value);
    }

    /**
     * @param $value
     * Set Price Attribute to Double
     * Match Type Case with database column type
     */
    public function setPriceAttribute($value){
        $this->attributes['price'] = (double)($value);
    }
}