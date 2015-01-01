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

class ImageRepository extends Eloquent
{

    protected $table = 'images';

    public $timestamps = true;



    public function sizedImages()
    {
        return $this->hasMany('Yesilcam\\SizedImageRepository','image_id','id');
    }

    /**
     * Naming of image for different occations
     * @param $width
     * @param $height
     * @return array
     */
    public function namer($width, $height)
    {
        $root = "{$this->id}-{$width}-{$height}";
        return [
            'sized' => "img-$root",
            'serve_count' => "imgserve:$root",
            'path'        => "imgpath:$root",
        ];
    }

    public function fullPath()
    {
        //TODO: might be a wrong way
        $dir = public_path( Config::get('yesilcam.image_dir') );
        return $dir.DIRECTORY_SEPARATOR.$this->path;
    }

} 