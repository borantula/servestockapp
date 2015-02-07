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
use Yesilcam\ImageProvider\ImageProvider;

class ImageProcessor extends Image {


    public $path = null;

    public $image;

    public $quality = 100;

    public function __construct(ImageProvider $provider,SizedImageRepository $sizedImage)
    {

        $this->provider = $provider;
        $this->originalImage = $provider->image();
        //check if sized image has smaller but same ratio version

        //check if sized image has smaller but same ratio version
        $sameRatioImage = $sizedImage->sameRatioBiggerSize($sizedImage)->first();
        if( !is_null($sameRatioImage) && !$this->provider->fromOriginal) {
            $this->originalImage = $sameRatioImage;
//            $this->quality = 100;
        }


        if( !$sameRatioImage && !$this->provider->fromOriginal) {


            // if no same ratio and original image will be used,
            // check for a small version of original image,
            // it should be bigger than requested
            $smallerOfOriginal = $this->originalImage->sizedImages()
                                        ->whereRatio($this->originalImage->ratio)
                                        ->where('width','>',$this->provider->width)
                                        ->where('height','>',$this->provider->height)
                                        ->where('file_exists',1)
                                        ->orderBy('width','ASC')
                                        ->first();

            if($smallerOfOriginal) {
//                \Log::info("Smaller of original used {$smallerOfOriginal->width} for {$this->provider->width}:{$this->provider->height}");
                $this->originalImage = $smallerOfOriginal;
            }

        }




        $this->sizedImage = $sizedImage;

        $this->image = Image::make($this->originalImage->fullPath());

        $this->process()->save();

    }

    public function process()
    {

        $this->image = $this->image->fit($this->provider->width,$this->provider->height,function ($constraint) {
            $constraint->upsize();
        });

        return $this;

        if( $this->provider->crop == false ) {
            $this->image = $this->image->resize($this->provider->width,$this->provider->height);
        } else {


            if( $this->provider->cropMethod == 'height' ) {
                //resize to width and crop
                $this->image = $this->image->widen($this->provider->width);
            } else if( $this->provider->cropMethod == 'width' ) {
                //resize to width and crop
                $this->image = $this->image->heighten($this->provider->height);
            } else {
                $this->image = $this->image->resize($this->provider->width,$this->provider->height);
            }
            $this->image->crop($this->provider->width,$this->provider->height);
        }



        return $this;
    }


    public function save()
    {
        $sizedImage = $this->sizedImage;
        $this->image = $this->image->save($sizedImage->fullPath(),$this->quality);
        return $this->image;
    }


}