<?php

use Acme\Photo\PhotoImageService;
use Acme\Photo\PhotoRepository;

class AdminPhotosController extends AdminBaseController {

    private $photoRepository;
    /**
     * @var Acme\Core\PhotoService
     */
    private $imageService;

    function __construct(PhotoRepository $photoRepository, PhotoImageService $imageService)
    {
        $this->photoRepository = $photoRepository;
        $this->imageService = $imageService;
        parent::__construct();
    }

    public function create()
    {
        $this->render('admin.events.photo');
    }

    public function destroy($id)
    {
        $photo = $this->photoRepository->findById($id);

        if ( $photo->delete() ) {

            $this->imageService->destory($photo->name);

            return Redirect::back()->with('success', 'Photo Deleted');
        }

        return Redirect::back()->with('error', 'Error: Photo Not Found');
    }
}
