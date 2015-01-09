<?php

namespace Yesilcam\ImageProvider;

use Yesilcam\ImageBase;
use Yesilcam\ImageRepository;
use \DB;
use \Config;
use \Image;

/**
 * Class ImageProvider
 * Gets width and height of a wanted image and prepares a
 * @package Yesilcam\ImageProvider
 */
class SelectedImageProvider extends ImageProvider {

    public function __construct($width,$height,ImageBase $image)
    {
        $this->selectedImage = $image;
        parent::__construct($width,$height);
    }

    /**
     * Search for the item
     */
    public function search()
    {
        $this->result = $this->selectedImage;
    }

} 