<?php
/**
 * Created by PhpStorm.
 * User: borayalcin
 * Date: 27/07/14
 * Time: 19:33
 */

namespace Yesilcam;

use \Eloquent;
use \Config;

class SizedImageRepository extends Eloquent
{

    protected $table = 'sized_images';

    public $timestamps = true;


    public function image()
    {
        return $this->belongsTo('Yesilcam\\ImageRepository','image_id','id');
    }

    public function scopeOfSize($query,$width,$height)
    {
        return $query->whereWidth($width)->whereHeight($height);
    }


    public function directory()
    {
        return Config::get('yesilcam.cropped_image_dir');
    }

    public function fullPath()
    {
        if( empty($this->path) ) {
            return false;
        }
        return public_path($this->path);
    }

} 