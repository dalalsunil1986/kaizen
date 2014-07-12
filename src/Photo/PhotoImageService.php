<?php
namespace Acme\Photo;

use Acme\Core\ImageService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotoImageService extends ImageService {

    public function store(UploadedFile $image)
    {
        $this->process($image,['large','medium','thumbnail']);
    }

} 