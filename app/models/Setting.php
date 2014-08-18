<?php

class Setting extends BaseModel {

    protected $guarded = array('');

    protected static $name = 'setting';

    protected $table = 'settings';

    public function settingable()
    {
        return $this->morphTo();
    }

}
