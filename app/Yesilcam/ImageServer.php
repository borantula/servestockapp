<?php

namespace Yesilcam;
use \Config;
use \Response;
use \Image;
use \Event;

use \Yesilcam\ImageProvider\ImageProvider;

class ImageServer {


    public $image;

    public $sizedImage;

    public function __construct(SizedImageRepository $sizedImage)
    {
        $this->sizedImage = $sizedImage;


        $this->image = Image::make($this->sizedImage->fullPath());
    }





    public function serve()
    {
        return $this->image->response('jpg');
    }

} 