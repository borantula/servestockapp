<?php

namespace Yesilcam;


class ImageFactory {

    /**
     * @var array
     */
    private $providers = [
//        'Yesilcam\ImageProvider\ExactRatioImageProvider',
//        'Yesilcam\ImageProvider\ExactSizeImageProvider',
//        'Yesilcam\ImageProvider\SameSideOfRatioImageProvider',
//        'Yesilcam\ImageProvider\OppositeSideOfRatioImageProvider',
        'Yesilcam\ImageProvider\RandomImageProvider',
    ];

    /**
     * @var array
     */
    private $usedProviders = [];

    /**
     * @var string
     */
    private $currentProviderName;

    public $currentProvider;

    private $width;

    private $height;

    private $result;

    public function __construct($width,$height)
    {

        $this->width = $width;
        $this->height = $height ? $height : $width;

        $this->run();

    }

    private function run()
    {
        $this->chooseProvider()->search();
        return $this;
    }

    private function chooseProvider()
    {
        $random = array_rand($this->providers);

        $this->currentProviderName = $this->providers[$random];

        //its used now remove it
        unset( $this->providers[$random] );

        return $this;
    }

    private function search()
    {
        $provider = new $this->currentProviderName($this->width,$this->height);

        $result = $provider->result();

        if( $result ) {
            $this->result = $provider;
            \Log::info('worked:'.$this->currentProviderName);
            return $provider;
        } else {
            return $this->run();
        }

    }

    public function getImageProvider()
    {
        if( $this->result ) {
            return $this->result;
        }
        return false;
    }


} 