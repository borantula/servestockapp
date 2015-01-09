<?php

namespace Yesilcam;

use \Eloquent;
use \Config;

class SizedImageRepository extends ImageBase
{

    protected $table = 'sized_images';

    public $timestamps = true;

    public $directoryKey = 'yesilcam.cropped_image_dir';


    /**
     * Naming of image for different occations,
     * it depends on parent image's name
     * @return array
     */
    public function namer()
    {
        $root = "{$this->image_id}-{$this->width}-{$this->height}";
        return [
            'sized' => "img-$root",
            'serve_count' => "imgserve:$root",
            'path'        => "imgpath:$root",
        ];
    }

    public function image()
    {
        return $this->belongsTo('Yesilcam\\ImageRepository','image_id','id');
    }

    public function scopeSameRatioBiggerSize($query,$current)
    {
        return $query->whereImageId($current->image_id)
                    ->whereRatio($current->ratio)
                    ->where('id','<>',$current->id)
                    ->where('width','>=',$current->width)
                    ->orderBy('width', 'asc');
    }


} 