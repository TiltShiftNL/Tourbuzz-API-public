<?php

namespace App\Service;

use App\Entity\Image;
use App\Entity\ImageRepo;
use Ramsey\Uuid\Uuid;

class ImageStoreService {

    /**
     * @var string
     */
    protected $rootPath;

    /**
     * @var string
     */
    protected $externalPath;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var ImageRepo
     */
    protected $imageRepo;

    public function __construct($rootPath, $externalPath, \Doctrine\ORM\EntityManager $em)
    {
        $this->rootPath     = $rootPath;
        $this->externalPath = $externalPath;
        $this->em           = $em;
        $this->imageRepo    = $em->getRepository('App\Entity\Image');
    }

    public function store(\SplFileInfo $fileInfo) {
        $uuid = Uuid::uuid4();
        $image = new Image();
        $filename = $uuid->toString() . '.' . $this->getExtension($fileInfo);
        $image->setFilename($filename);
        $imageInfo = $this->getImageInfo($filename);
        if (file_exists($imageInfo)) {
            return $this->store($fileInfo);
        }
        copy($fileInfo, $imageInfo);
        $this->em->persist($image);
        $this->em->flush();
        return $image;
    }

    public function getImageUrl($imageId) {
        if (null === $imageId) {
            return null;
        }

        /**
         * @var Image $image
         */
        $image = $this->imageRepo->findOneById($imageId);
        return $this->getPath($image->getFilename()) . $image->getFilename();
    }

    public function getFilePath($imageId) {
        if (null === $imageId) {
            return null;
        }

        /**
         * @var Image $image
         */
        $image = $this->imageRepo->findOneById($imageId);
        if (null == $image) {
            return null;
        }

        return new \SplFileInfo($this->getPath($image->getFilename(), true, false) . $image->getFilename());
    }

    protected function getImageInfo($filename) {
        $path = $this->getPath($filename, true, true);
        $imageInfo = new \SplFileInfo($path . $filename);
        return $imageInfo;
    }

    protected function getExtension(\SplFileInfo $fileInfo) {
        $extension = '';
        switch (exif_imagetype($fileInfo)) {
            case IMAGETYPE_GIF:
                $extension = 'gif';
                break;
            case IMAGETYPE_JPEG:
                $extension = 'jpg';
                break;
            case IMAGETYPE_PNG:
                $extension = 'png';
                break;
            default:
                throw new \Exception('Unknown image type');
        }
        return $extension;
    }

    protected function getPath($filename, $internal = false, $createDir = false) {
        $dir = ($internal ? $this->rootPath : $this->externalPath) . $filename[0] . '/' . $filename[1] . '/';
        if ($internal && $createDir && !is_dir($dir)) {
            mkdir($dir, 0770, true);
        }
        return $dir;
    }
}