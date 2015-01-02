<?php

namespace Yesilcam;

use Yesilcam\ImageProvider\ImageProvider;


class SizedImageFactory {


    /**
     * @var string
     */
    public $currentProviderName;

    public $currentProvider;

    private $width;

    private $height;

    private $image;

    private $sizedImage;

    public function __construct(ImageProvider $imageProvider)
    {

        $this->provider = $imageProvider;
        $this->image = $this->provider->image();
        $this->width = $this->provider->width;
        $this->height = $this->provider->height;


    }

    public function find()
    {

        //search if it already has sized image of current image
        $sizedImage = $this->image->sizedImages()->ofSize($this->width,$this->height)->first();

        //if not, process and record a new image
        if( !$sizedImage ) {

            \Debugbar::info('New image is preparing');

            $sized = new SizedImageRepository();
            $sized->width = $this->width;
            $sized->height = $this->height;
            $sized->ratio = $this->provider->ratio;
            $sized->image_id = $this->image->id;
            $sized->save();

            //get image path
            $pathFinder = new ImagePathFinder($this->image,$sized);
            $path = $pathFinder->path();

            //set its path
            $sized->path = $path;


            //process image accordingly
            $imageProcessor = new ImageProcessor($this->provider,$sized);
            $process = $imageProcessor->process()->save();


            $sized->file_exists = true;


            //save it
            $sized->save();

            $sizedImage = $sized;
        }

        return $sizedImage;
    }




} 