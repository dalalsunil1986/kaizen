<?php namespace Acme\Core\Repositories;

interface Repository {

    /**
     * Search by key and value
     *
     * @param string $key
     * @param mixed $value
     * @param array $with
     * @return \Illuminate\Database\Query\Builders
     */
    public function getBy($key, $value, array $with = array());

    /**
     * Return the errors
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function errors();

    /**
     * Add error to MessageBag
     * @param $errorMsg
     * @return \Illuminate\Support\MessageBag
     */
    public function addError($errorMsg);

}
