<?php

class AdminPhotosController extends BaseController {

    function __construct(Photo $model)
    {
        $this->model = $model;

        parent::__construct();
        $this->beforeFilter('Admin');
    }
	public function destroy($id)
	{
        $photo=  $this->model->findOrFail($id);
        if ($photo->delete()) {
            //  return Redirect::home();
            $this->model->destroyFile($photo->name);
            return Redirect::back()->with('success','Photo Deleted');
        }
        return Redirect::back()->with('error','Error: Photo Not Found');
	}
}
