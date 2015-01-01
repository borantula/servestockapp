<?php

namespace Yesilcam;

use \File;
use \Image;
use \Config;

/**
 *
 * ImageProcessor
 * dosyaların taranıp veritabanına kaydedilmesi
 *
 * ImageProvider
 *
 * requestin anlamlandırılması
 *
 * uygun imajın bulunması
 *
 * imajın kesilmesi
 *
 *
 */

/**
 * Class ImageProcessor
 * Discovers and records images to database
 * @package Yesilcam
 */
class ImageScanner {


    public $dir = null;

    /**
     * Valid files from folder
     * @var array
     */
    public $files = array();

    public $validExtentions = array(
        'jpg','png','jpeg'
    );


    public function __construct()
    {
        $this->dir = public_path( Config::get('yesilcam.image_dir') );
    }


    public function folderExists()
    {
        return is_dir($this->dir);
    }

    public function getValidFiles()
    {
        $files =  File::allFiles( $this->dir );
        if( empty($files) ) {
            return false;
        }

        $validFiles = array();

        //set valid files
        foreach ($files as $file) {

            if( $this->isFileValid($file->getRelativePathname()) ) {
                $validFiles[] = $file->getRelativePathname();
            }

        }

        $this->files = $validFiles;

        return $this->files;
    }

    public function isFileValid($path)
    {
        $ext = File::extension($path);
        return in_array($ext,$this->validExtentions);
    }

    public function fullPath($relativePath) {
        return $this->dir.DIRECTORY_SEPARATOR.$relativePath;
    }

    /**
     * Register images to database
     */
    public static function registerImage($path,$width,$height)
    {
        //check exists
        $img = ImageRepository::where('path',$path)->first();

        if( !$img ) {
            $img = new ImageRepository();

            $img->path = $path;
            $img->width = $width;
            $img->height = $height;
            $img->ratio = 100 * round($width/$height,2);

            $img->save();
        }

        return $img;
    }
}


