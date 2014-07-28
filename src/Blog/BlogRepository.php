<?php namespace Acme\Blog;

use Acme\Core\CrudableTrait;
use Acme\Core\Repositories\AbstractRepository;
use Blog;
use Illuminate\Support\MessageBag;

class BlogRepository extends AbstractRepository {

    use CrudableTrait;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    public function __construct(Blog $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }


    public function getConsultancyPosts()
    {
        return $this->model->with(['category','photos','author'])
                ->select('posts.*')
                ->leftJoin('categories','categories.id','=','posts.category_id')
                ->where('categories.name_en','=','consultancy')
                ->orderBy('posts.created_at','DESC')
                ->paginate(10);
    }
}