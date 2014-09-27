<?php

use Acme\Core\LocaleTrait;

class Tag extends Eloquent {

    use LocaleTrait;
    protected $localeStrings = ['name'];
    protected $guarded = [];
    protected $table = 'tags';
    public $timestamps = false;
    public function events()
    {
        return $this->morphedByMany('EventModel', 'taggable')->withPivot(['tag_id']);
    }

    public function blogs()
    {
        return $this->morphedByMany('Blog', 'taggable');
    }


}