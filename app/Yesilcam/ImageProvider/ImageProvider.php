<?php

namespace Yesilcam\ImageProvider;

use Yesilcam\ImageRepository;
use \DB;
use \Config;

/**
 * Class ImageProvider
 * Gets width and height of a wanted image and prepares a
 * @package Yesilcam\ImageProvider
 */
abstract class ImageProvider
{

    /**
     * Width of request
     * @var integer
     */
    public $width;

    /**
     * Height of request
     * @var integer
     */
    public $height;


    /**
     * ratio of width/height multipled by 100
     * @var interger
     */
    protected $ratio;

    /**
     * @var \ImageRepository|bool
     */
    protected $result = false;

    public $crop = false;
    public $cropMethod = 'width';


    /**
     * @param $width
     * @param null $height
     */
    public function __construct($width, $height)
    {
        $this->width  = $width;
        $this->height = $height ? $height : $width;


        $this->setRatio();

        $this->search();
    }

    protected function setRatio()
    {
        $this->ratio  = 100 * round($this->width / $this->height, 2);
    }



    /**
     * Returns the result if found one
     * @return bool|\ImageRepository
     */
    public function result()
    {
        return $this->result;
    }

    public function image()
    {
        return $this->result();
    }


}