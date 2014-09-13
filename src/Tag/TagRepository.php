<?php namespace Acme\Tag;

use Acme\Core\CrudableTrait;
use Acme\Core\Repositories\Illuminate;
use Acme\Core\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Model;
use Tag;

class TagRepository extends AbstractRepository {

    use CrudableTrait;

    public $model;

    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

    public function create($tags)
    {
        dd($tags);
    }

    /**
     * @param $model
     * @param $tagArray [Input::get('tag') ]
     * update the taggables
     */
    public function attachTags(Model $model, array $tagArray)
    {
        // attach related tags
        // fetch all tags
        $tags = $model->tags;

        // fetch all tags in the database assosiated with this event
        $attachedTags = $tags->lists('id');

        if ( !empty($attachedTags) ) {
            // if there are any tags assosiated with the event
            if ( empty($tagArray) ) {
                // if no tags in the GET REQUEST, delete all the tags
                foreach ( $attachedTags as $tag ) {
                    // delete all the tags
                    $model->tags()->detach($tag);
                }
            } else {
                // If the used tags is unselected in the GET REQUEST, delete the tags
                foreach ( $attachedTags as $tag ) {
                    if ( !in_array($tag, $tagArray) ) {
                        $model->tags()->detach($tag);
                    }
                }
            }
        }

        // attach the tags
        if ( !empty($tagArray) ) {
            $model->tags()->sync($tagArray, true);
        }
    }
}