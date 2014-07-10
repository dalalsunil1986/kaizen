<?php
namespace Acme\Photo;

use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class PhotoService {

    /**
     * @var PhotoRepository
     */
    protected $repository;

    protected $hashedName;

    protected $uploadDir;

    protected $thumbnailImagePath;

    protected $largeImagePath;

    protected $mediumImagePath;

    protected $largeDimension = '750,650';

    protected $mediumDimension = '550,500';

    protected $thumbnailDimension = '250,200';

    private function init(UploadedFile $image)
    {
        $this->hashedName         = md5(uniqid(rand() * (time()))) . '.' . $image->getClientOriginalExtension();
        $this->uploadDir          = public_path() . '/uploads/';
        $this->largeImagePath     = $this->getUploadDir() . 'large/';
        $this->mediumImagePath    = $this->getUploadDir() . 'medium/';
        $this->thumbnailImagePath = $this->getUploadDir() . 'thumbnail/';
    }

    abstract function store(UploadedFile $image);

    function process(UploadedFile $image, array $imageDimensions = [])
    {
        $this->init($image);
        $imageRealPath = $image->getRealPath();
        foreach($imageDimensions as $imageDimension) {
            switch ($imageDimension) {
                case 'large':
                    Image::make($imageRealPath)->resize($this->largeDimension)->save($this->largeImagePath.$this->hashedName);
                    break;
                case 'medium':
                    Image::make($imageRealPath)->resize($this->mediumDimension)->save($this->mediumImagePath.$this->hashedName);
                    break;
                case 'thumbnail':
                    Image::make($imageRealPath)->resize($this->thumbnailDimension)->save($this->thumbnailImagePath.$this->hashedName);
                    break;
                default :
                    break;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getUploadDir()
    {
        return $this->uploadDir;
    }

    /**
     * @return mixed
     */
    public function getLargeImagePath()
    {
        return $this->largeImagePath;
    }

    /**
     * @return mixed
     */
    public function getMediumImagePath()
    {
        return $this->mediumImagePath;
    }

    /**
     * @return mixed
     */
    public function getThumbnailImagePath()
    {
        return $this->thumbnailImagePath;
    }

    /**
     * @return mixed
     */
    public function getHashedName()
    {
        return $this->hashedName;
    }



}