<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::pattern('width', '[0-9]+');
Route::pattern('height', '[0-9]+');

Route::get('/{width?}/{height?}', function($width = null,$height = null)
{
    //if width is not set, its homepage
    if( is_null($width) ) {


        return View::make('hello');

    } else {
        if(is_null($height)) {
            $height = $width;
        }

        //TODO:get to a controller
        $provider = new Yesilcam\ImageProvider();

        $result = $provider->search($width,$height);

//        var_dump($result);
        return $provider->serve($result);
    }

});

Route::get('/test/{width?}/{height?}', function($width = null,$height = null)
{

    //if width is not set, its homepage
    if( is_null($width) ) {


        return View::make('hello');

    } else {
        $factory = new Yesilcam\ImageFactory($width,$height);

        //we have a result now, as an image provider
        $provider = $factory->getImageProvider();

        //this will be the image we will
        $sizedImageFactory = new Yesilcam\SizedImageFactory($provider);

        $sizedImage = $sizedImageFactory->find();



        if( $sizedImage ) {
            $imageServer  = new Yesilcam\ImageServer($sizedImage);


//            Event::fire('image.serving',$imageServer);
            return $imageServer->serve();
        }

    }

});





Route::get('scan', function()
{
    $scanner = new \Yesilcam\ImageScanner();

    $scanner->getValidFiles();


    foreach($scanner->files as $key => $file) {


        var_dump( $scanner->fullPath($file) );

        $imagePath = $scanner->fullPath($file);

        $imageObj = new Yesilcam\ImageProcessor($imagePath);

        $image = $imageObj->image();

        //register
        \Yesilcam\ImageScanner::registerImage( $file,$image->width(),$image->height() );

    }
});


Route::get('redis',function(){
    $redis = Redis::connection();
//    Debugbar::startMeasure('render','Redis saving');
//    $redis->set('imgpath:1-500-400',public_path('images/arzufilms'));
//    $redis->set('imgpath:1-200-400',public_path('images/arzufilms'));
//    $redis->set('imgpath:1-5300-400',public_path('images/arzufilms'));
//    Debugbar::stopMeasure('render');
    dump($redis->get('imgtest'));
});