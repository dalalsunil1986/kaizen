<?php
use Intervention\Image\Facades\Image;

class Photo extends BaseModel {
    protected $guarded = array();

    public static $rules = array();

    public function imageable()
    {
        return $this->morphTo();
    }

    public  function attachFeatured($id,$image) {
        // Image::make(Input::file('photo')->getRealPath())->resize(300, 200)->save('foo.jpg');
        $image_name = time() . '-' . $image->getClientOriginalName();
        // $image->move(public_path().'/images/'.$image_name);
        try {
            Image::make($image->getRealPath())->save(public_path() . '/uploads/' . $image_name);
            $data = Photo::create(
                [
                    'name' => $image_name,
                    'imageable_id' => $id,
                    'imageable_type' => 'EventModel',
                    //  'featured' => Input::get('featured')
                ]
            );
            $data->save();
            return true;

        } catch (InvalidImageTypeException $e) {
//            return Redirect::to(LaravelLocalization::localizeURL('event/' . $validation->id . '/edit'))->withErrors($e->getMessage());
            return false;
        }
    }
}
