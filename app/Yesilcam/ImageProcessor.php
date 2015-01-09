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

    public $quality = 75;

    public function __construct(ImageProvider $provider,SizedImageRepository $sizedImage)
    {

        $this->provider = $provider;
        $this->originalImage = $provider->image();

        //check if sized image has smaller but same ratio version
        $sameRatioImage = $sizedImage->sameRatioBiggerSize($sizedImage)->first();
        if( !is_null($sameRatioImage) ) {
            $this->originalImage = $sameRatioImage;
            $this->quality = 100;
        }

        $this->sizedImage = $sizedImage;

        $this->image = Image::make($this->originalImage->fullPath());

        $this->process()->save();

    }

    public function process()
    {
        $this->image = $this->image->fit($this->provider->width,$this->provider->height);

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