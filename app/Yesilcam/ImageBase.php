<?php
/**
 * Created by PhpStorm.
 * User: borayalcin
 * Date: 01/01/15
 * Time: 23:29
 */

namespace Yesilcam;

use \Eloquent;
use \Config;

abstract class ImageBase extends Eloquent{

    public $directoryKey = 'yesilcam.cropped_image_dir';

    public function scopeOfSize($query,$width,$height)
    {
        return $query->whereWidth($width)->whereHeight($height);
    }




    public function directory()
    {
        return Config::get($this->directoryKey);
    }


    public function relativePath()
    {
        //TODO: might be a wrong way
        $dir = $this->directory();
        return $dir.DIRECTORY_SEPARATOR.$this->path;
    }

    public function fullPath()
    {
        if( empty($this->path) ) {
            return false;
        }
        return public_path($this->path);
    }



}