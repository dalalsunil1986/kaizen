<?php

use Acme\Core\LocaleTrait;

class Setting extends BaseModel {

    use LocaleTrait;

    protected $guarded = ['id'];

    protected static $name = 'setting';

    protected $localeStrings = ['vip_benefits','online_benefits','normal_benefits','vip_description','online_description','normal_description'];

    protected $table = 'settings';

    public function settingable()
    {
        return $this->morphTo();
    }

}
