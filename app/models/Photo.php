<?php
use Intervention\Image\Facades\Image;

class Photo extends BaseModel {

    protected $image_path;

    protected $guarded = array('id');
    public static $rules = array(
        'name' => 'required'
    );
    protected static function boot()
    {
        static::saved(function($model)
        {
            if($model->imageable_type=='Ad') {
                Cache::forget('cache.ad1');
                Cache::forget('cache.ad2');
            }
        });
        parent::boot();
    }


    public function imageable()
    {
        return $this->morphTo();
    }

    public  function attachImage($id,$image, $type, $featured='0') {
//        Image::make(Input::file('photo')->getRealPath())->resize(300, 200)->save('foo.jpg');
        // set random unique image name
//        Image::make(Input::file('photo')->getRealPath())->resize(300, 200)->save('foo.jpg');
        // set random unique image name

        $image_name = md5(uniqid(rand()*(time()))). '.' . $image->getClientOriginalExtension();

        // specify the path where you want to save your images
        $image_path = public_path() . '/uploads/';

        // the whole image path
        $image_path_name = $image_path.$image_name;
        $thumbnail_path_name = $image_path.'thumbnail/'.$image_name;
        $medium_path_name = $image_path.'medium/'.$image_name;
        $large_path_name = $image_path.'large/'.$image_name;


        // try to move and upload the file
        try {
            if($type == 'Ad') {
                Image::make($image->getRealPath())->resize(460,125)->save($image_path_name);
            } else {
                Image::make($image->getRealPath())->save($image_path_name);
                Image::make($image->getRealPath())->resize(150,150)->save($thumbnail_path_name);
                Image::make($image->getRealPath())->resize(450,400)->save($medium_path_name);
                Image::make($image->getRealPath())->resize(715,400)->save($large_path_name);
            }

            // if the featured image is already exists in the db, replace it with the new image
            $data = Photo::where('imageable_id',$id)->where('imageable_type',$type)->where('featured', $featured)->first();

            if($data) {
                //delete old files
                $this->destroyFile($image_path,$data->name);
                // set the image name to save in database
                $data->name = $image_name;
            } else {
                // create a new entry in  the database
                $data = new Photo();
                $data->name = $image_name;
                $data->imageable_id = $id;
                $data->imageable_type = $type;
                $data->featured = $featured;
            }
            if(!$data->save()){
                // if validation fails
                $this->errors = $data->getErrors();
                return false;
            }
            return true;
        } catch (\Exception $e) {
            // invalid iamges
            $this->errors = $e->getMessage();
            return false;
        }
    }

    public function destroyFile($imageName) {
        $this->image_path = public_path() . '/uploads/';
        $originalImage = $this->image_path.$imageName;
        $thumbnailImage = $this->image_path.'thumbnail/'.$imageName;
        $mediumImage = $this->image_path.'medium/'.$imageName;
        $largeImage = $this->image_path.'large/'.$imageName;
        if(file_exists($originalImage)) {
            unlink($originalImage);
        }
        if(file_exists($thumbnailImage)) {
            unlink($thumbnailImage);
        }
        if(file_exists($mediumImage)) {
            unlink($mediumImage);
        }
        if(file_exists($largeImage)) {
            unlink($largeImage);
        }
    }

}
