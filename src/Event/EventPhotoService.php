<?php
namespace Acme\Event;

use Acme\Photo\PhotoService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EventPhotoService extends PhotoService {

    public function store(UploadedFile $image) {
        $this->process($image,['thumbnail']);
    }
} 