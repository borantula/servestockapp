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

class ImageRepository extends ImageBase
{

    protected $table = 'images';

    public $timestamps = true;


    public $directoryKey = 'yesilcam.image_dir';

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
        return public_path( $this->relativePath() );
    }




} 