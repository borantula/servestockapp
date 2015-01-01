<?php

namespace Yesilcam\ImageProvider;

use Yesilcam\ImageRepository;
use \DB;
use \Config;
use \Image;

/**
 * Class ImageProvider
 * Gets width and height of a wanted image
 * @package Yesilcam\ImageProvider
 */
class SameSideOfRatioImageProvider extends  ImageProvider {

    public $crop = true;
    public $cropMethod = 'width';

    /**
     * Search for the item
     */
    public function search()
    {
        $this->result = ImageRepository::where('ratio','>=',$this->ratio)
            ->where('width','>=',$this->width)
            ->where('height','>=',$this->height)
            ->orderBy('ratio','ASC')
            ->orderBy(DB::raw('RAND()'))
            ->take(10)
            ->first();
    }



} 