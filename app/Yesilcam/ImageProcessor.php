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

    public function __construct(ImageProvider $provider,SizedImageRepository $sizedImage)
    {

        $this->provider = $provider;
        $this->originalImage = $provider->image();
        $this->sizedImage = $sizedImage;

        $this->image = Image::make($this->originalImage->fullPath());

        $this->process()->save();

    }

    public function process()
    {
        if( $this->provider->crop === false ) {
            $this->image = $this->image->resize($this->provider->width,$this->provider->height);
        }

        if( $this->provider->crop ) {
            if( $this->provider->cropMethod == 'width' ) {
                //resize to width and crop
                $this->image = $this->image->resize($this->provider->width,null,function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else if( $this->provider->cropMethod == 'height' ) {
                //resize to width and crop
                $this->image = $this->image->resize(null,$this->provider->height,function ($constraint) {
                    $constraint->aspectRatio();
                });
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
        $this->image = $this->image->save($sizedImage->fullPath());
        return $this->image;
    }


}