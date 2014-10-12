<?php
namespace Acme\Ad;

use Acme\Core\AbstractImageService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService extends AbstractImageService {

    protected $thumbnailImageWidth = '450';

    protected $thumbnailImageHeight = '125';

    public function store(UploadedFile $image) {

       return $this->process($image,['thumbnail']);

    }

} 