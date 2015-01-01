<?php

namespace Yesilcam\ImageProvider;

use Yesilcam\ImageRepository;
use \DB;
use \Config;
use \Image;

/**
 * Class ImageProvider
 * Searches for an image of opposite ratio direction.
 * So this time width->height and height->width relation is needed
 * Also ratio is inverted
 * @package Yesilcam\ImageProvider
 */
class OppositeSideOfRatioImageProvider extends ImageProvider
{

    public $crop = true;
    public $cropMethod = 'height';

    /**
     * Search for the item
     */
    public function search()
    {
        $this->result = ImageRepository::where('ratio', '>', $this->ratio)
            ->where('width', '>=', $this->height)
            ->where('height', '>=', $this->width)
            ->orderBy('ratio', 'ASC')
            ->orderBy(DB::raw('RAND()'))
            ->take(2)
            ->first();
    }


    protected function setRatio()
    {
        parent::setRatio();
        $this->ratio  = round(pow($this->ratio/100, -1), 2) * 100;
    }

} 