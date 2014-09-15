<?php

use Acme\Core\LocaleTrait;

class Tag extends Eloquent {

    use LocaleTrait;
    protected $localeStrings = ['name'];
	protected $fillable = [];
    protected $table = 'tags';

    protected $with = 'events';

    public function events()
    {
        return $this->morphedByMany('EventModel', 'taggable');
    }

    public function blogs()
    {
        return $this->morphedByMany('Blog', 'taggable');
    }

}