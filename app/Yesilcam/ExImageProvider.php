<?php

namespace Yesilcam;
use \Image;
use \DB;
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


class ExImageProvider {

    public $width;
    public $height;
    public $ratio;

    /**
     * Has smaller ratio
     * @var bool
     */
    public $smallerRatioItem = false;

    /**
     *  bigger ratio
     * @var bool
     */
    public $biggerRatioItem = false;

    public function search($width,$height)
    {
        $ratio = round($width/$height,2);


        $this->width = $width;
        $this->height = $height;
        $this->ratio = $ratio;

        $this->setItems();

        //look for closest ratio, get one bigger, one smaller ratio
        $bigItem = $this->biggerRatioItem;

        $smallOne = $this->smallerRatioItem;

        //check if bigger ratio item exists, if it does cut from it
        $bigDiff = false;
        $smallDiff = false;

        if( $bigItem ) {
            $bigDiff = abs( $bigItem->ratio - $ratio );
        }

        if( $smallOne ) {
            $smallDiff = abs( $ratio - $smallOne->ratio );
        }

        //if both of them exists
        if( $smallDiff !== false && $bigDiff !== false ) {

            //difference is in favor of small
            if( ($bigDiff - $smallDiff) >= 0 ) {
                return $smallOne;
            }
            return $bigItem;
        }

        if( $smallDiff === false && $bigDiff ) {
            return $bigItem;
        }

        if( $bigDiff === false && $smallOne ) {
            return $smallOne;
        }
    }


    public function setItems()
    {
        $this->smallerRatioItem = ImageRepository::where('ratio','<',$this->ratio)
            ->where('width','>',$this->width)
            ->where('height','>',$this->height)->orderBy('ratio','DESC')->orderBy(DB::raw('RAND()'))->take(5)->first();

        $this->biggerRatioItem = ImageRepository::where('ratio','>=',$this->ratio)
            ->where('width','>',$this->width)
            ->where('height','>',$this->height)->orderBy('ratio','ASC')->orderBy(DB::raw('RAND()'))->take(5)->first();
    }


    public function serve(ImageRepository $image)
    {
        $dir = public_path( Config::get('yesilcam.image_dir') );
        $path = $dir.DIRECTORY_SEPARATOR.$image->path;
//        echo $path;
        return Image::make($path)->resize($this->width,$this->height)->response('png');
    }

} 