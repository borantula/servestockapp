<?php

namespace Yesilcam\ImageProvider;

use Yesilcam\ImageRepository;
use \DB;
use \Config;
use \Image;

/**
 * Class ImageProvider
 * Gets width and height of a wanted image and prepares a
 * @package Yesilcam\ImageProvider
 */
class RandomImageProvider extends  ImageProvider {

    /**
     * Search for the item
     */
    public function search()
    {
        $this->result = ImageRepository::where('width','>=',$this->width)
            ->where('height','>=',$this->height)
            ->orderBy(DB::raw('RAND()'))
            ->take(1)
            ->first();
    }

} 