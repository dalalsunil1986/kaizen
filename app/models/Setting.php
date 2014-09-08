<?php

use Acme\Core\LocaleTrait;

class Setting extends BaseModel {

    use LocaleTrait;
    protected $guarded = array('');

    protected static $name = 'setting';

    protected $localeStrings = ['vip_benefits','online_benefits','normal_benefits'];

    protected $table = 'settings';

    public function settingable()
    {
        return $this->morphTo();
    }

}
