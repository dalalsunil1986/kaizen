<?php
use Intervention\Image\Facades\Image;
class Photo extends BaseModel {
    protected $guarded = array('id');
    public static $rules = array(
        'name' => 'required'
    );

    public function imageable()
    {
        return $this->morphTo();
    }

    public  function attachImage($id,$image, $type='EventModel', $featured='0') {
        // set random unique image name
        $image_name = md5(time()). '.' . $image->getClientOriginalExtension();

        // specify the path where you want to save your images
        $image_path = public_path() . '/uploads/';

        // the whole image path
        $image_path_name = $image_path.$image_name;

        // try to move and upload the file
        try {


            Image::make($image->getRealPath())->save($image_path_name);

            // if the featured image is already exists in the db, replace it with the new image
            $data = Photo::where('imageable_id',$id)->where('imageable_type',$type)->where('featured', $featured)->first();

            if($data) {
                //delete old files
                $old_image = $image_path.$data->name;
                if(file_exists($old_image)) {
                    unlink($old_image);
                }
                $data->name = $image_name;
            } else {
                // create a new entry in  the database
                $data = new Photo();
                $data->name = $image_name;
                $data->imageable_id = $id;
                $data->imageable_type = 'EventModel';
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

}
