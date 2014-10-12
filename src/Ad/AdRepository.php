<?php namespace Acme\Ad;

use Acme\Core\CrudableTrait;
use Acme\Core\Repositories\AbstractRepository;
use Ad;
use DB;
use Illuminate\Support\MessageBag;

class AdRepository extends AbstractRepository {

    use CrudableTrait;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    /**
     * @param Ad $model
     */
    public function __construct(Ad $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

    public function getAds()
    {
        $query = $this->model->where('active', 1)->whereHas('photos',function($q) {
            $q->latest()->take(1);
        })->take(2)->get();
        return $query;
    }

//    public function getAd1() {
//        $image = $this->model->where('imageable_id',1)->where('imageable_type','Ad')->remember(60,'cache.ad1')->pluck('name');
//        return $image;
//    }
//
//    public function getAd2() {
//        $image = $this->model->where('imageable_id',2)->where('imageable_type','Ad')->remember(60,'cache.ad2')->pluck('name');
//        return $image;
//    }
}