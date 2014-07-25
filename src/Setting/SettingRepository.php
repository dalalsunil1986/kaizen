<?php namespace Acme\Setting;

use Acme\Core\CrudableTrait;
use Acme\Core\Repositories\AbstractRepository;
use Acme\Core\Repositories\Illuminate;
use Setting;

class SettingRepository extends AbstractRepository {

    use CrudableTrait;

    public $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    public function update($id, array $input)
    {
        $record = $this->findById($id);

        // join the assosiate array and convert it to string
        if ( ! empty($input['registration_types']) ) {
            $input['registration_types'] = implode(',', $input['registration_types']);
        }

        $record->fill($input);

        if ( $this->save($record) ) return true;

        $this->addError('Could Not Update');

        return false;
    }

}