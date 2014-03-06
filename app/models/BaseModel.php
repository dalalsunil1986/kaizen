<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Validation\Validator;
use Carbon\Carbon;

class BaseModel extends Eloquent
{

    // fallback $guarded
    protected $guarded = array('_token', '_method', 'id');

    //fallback $rules

    /**
     * Error message bag
     *
     * @var Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * Validation rules
     *
     * @var Array
     */
    protected static $rules = array();

    /**
     * Custom error messages
     *
     * @var array
     */
    protected static $messages = array();

    /**
     * Validator instance
     *
     * @var Illuminate\Validation\Validators
     */
    protected $validator;

    public function __construct(array $attributes = array(), Validator $validator = null)
    {
        parent::__construct($attributes);

        $this->validator = $validator ?: \App::make('validator');
    }

    /**
     * Listen for save event
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function($model)
        {
            return $model->validate();
        });
    }

    /**
     * Validates current attributes against rules
     */
    public function validate()
    {
        $replace = ($this->getKey() > 0) ? $this->getKey() : '';
        foreach (static::$rules as $key => $rule)
        {
            static::$rules[$key] = str_replace(':id', $replace, $rule);
        }

        $validator = $this->validator->make($this->attributes, static::$rules, static::$messages);

        if ($validator->passes()) return true;

        $this->setErrors($validator->messages());

        return false;
    }

    /**
     * Set error message bag
     *
     * @var Illuminate\Support\MessageBag
     */
    protected function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Retrieve error message bag
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Return if there are any errors
     *
     * @return bool
     */
    public function hasErrors()
    {
        return ! empty($this->errors);
    }




    protected function getHumanTimestampAttribute($column)
    {
        if ($this->attributes[$column])
        {
            return Carbon::parse($this->attributes[$column])->diffForHumans();
        }

        return null;
    }

    public function getHumanCreatedAtAttribute()
    {
        return $this->getHumanTimestampAttribute("created_at");
    }

    public function getHumanUpdatedAtAttribute()
    {
        return $this->getHumanTimestampAttribute("updated_at");
    }


    /**
     * Get single model by slug
     *
     * @param string slug
     * @return object object of model
     */
    public  function bySlug($slug)
    {
        return $this->model->whereSlug($slug)->first();
    }
}
?>