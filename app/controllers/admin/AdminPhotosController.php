<?php

use Acme\Photo\PhotoRepository;

class AdminPhotosController extends AdminBaseController {

    private $photoRepository;
    /**
     * @var Acme\Event\EventPhotoService
     */
    private $eventPhotoService;

    function __construct(PhotoRepository $photoRepository, \Acme\Event\EventPhotoService $eventPhotoService)
    {
        $this->photoRepository = $photoRepository;
        parent::__construct();
        $this->eventPhotoService = $eventPhotoService;
    }

    public function create(){
        $this->render('admin.events.photo');
    }

    public function store()
    {
        $image = Input::get('filename');
        $this->eventPhotoService->process($image);
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
