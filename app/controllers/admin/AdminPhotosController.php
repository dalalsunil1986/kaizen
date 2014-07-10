<?php

use Acme\Photos\PhotoRepository;

class AdminPhotosController extends AdminBaseController {

    private $photoRepository;

    function __construct(PhotoRepository $photoRepository)
    {
        $this->photoRepository = $photoRepository;
        parent::__construct();
    }

    public function create(){
        $this->render('admin.events.photo');
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
