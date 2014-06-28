<?php namespace Acme\Blog;

use Acme\Blog\Validators\BlogCreateValidator;
use Acme\Blog\Validators\BlogUpdateValidator;
use Acme\Core\CrudableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\MessageBag;
use Acme\Core\Repositories\Paginable;
use Acme\Core\Repositories\Repository;
use Acme\Core\Repositories\AbstractRepository;
//use Subscription;

class EloquentBlogRepository extends AbstractRepository implements Repository, Paginable, BlogRepository {

    use CrudableTrait;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * Construct
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @internal param \Illuminate\Database\Eloquent\Model $user
     */
    public function __construct(Model $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

//    public static function isSubscribed($id,$userId) {
//        $query = Subscription::where('user_id', '=', $userId)->where('event_id', '=', $id)->count();
//        return ($query >= 1 ) ? true : false;
//    }

    public function getCreationForm()
    {
        return new BlogCreateValidator();
    }

    public function getEditForm($id)
    {
        return new BlogUpdateValidator($id);
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