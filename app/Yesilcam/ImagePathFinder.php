<?php
/**
 * Created by PhpStorm.
 * User: borayalcin
 * Date: 27/07/14
 * Time: 19:47
 */

namespace Yesilcam;
use \Image;
use \Config;
use \File;

/**
 * Save an image from a ImageServer class
 * Class ImageRecorder
 * @package Yesilcam
 */
class ImagePathFinder extends Image {


    public $path = null;

    /**
     * Image object
     * @var
     */
    public $image;
    public $imageServer;

    public $dir;

    public $names;

    public $filepath;

    public $extention = '.jpg';

    public function __construct(ImageRepository $image,SizedImageRepository $sizedImage)
    {
        $this->image = $image;
        $this->sizedImage = $sizedImage;
        $this->names = $image->namer($sizedImage->width,$sizedImage->height);

        $this->dir = $sizedImage->directory();

        //filepath
        $this->setPath();
    }

    public function path()
    {
        return $this->filepath;
    }


    private function setPath()
    {
        $this->filepath = $this->dir . DIRECTORY_SEPARATOR.$this->names['sized'].$this->extention;
        return $this;
        /*
        if( !File::isFile($path) ) {
            return $this->image->save($path);
        }
        */
    }

}