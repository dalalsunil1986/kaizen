<?php
namespace Acme\Event;

use Acme\Core\ImageService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EventImageService extends ImageService {

    public function store(UploadedFile $image) {

        $this->process($image,['thumbnail','large','medium']);

    }

} 