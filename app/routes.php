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


        return View::make('test-view');

    } else {

    }

});

Route::get('/test/{width?}/{height?}', function($width = null,$height = null)
{

    //if width is not set, its homepage
    if( is_null($width) ) {


        return View::make('hello');

    } else {
        /*
        $get = Input::get('str');
        if( !isset($get) ) {
            $random = str_random(16);
            return Redirect::to("test/{$width}/{$height}?str={$random}");
        }
        */
        Debugbar::startMeasure('getting','Time for getting an image');
        $factory = new Yesilcam\ImageFactory($width,$height);

        //we have a result now, as an image provider
        $provider = $factory->getImageProvider();

        //this will be the image we will
        $sizedImageFactory = new Yesilcam\SizedImageFactory($provider);

        $sizedImage = $sizedImageFactory->find();
        Debugbar::stopMeasure('render');

//        dump($sizedImage->toArray());

        Debugbar::startMeasure('serving','Time for serving an image');
        if( $sizedImage ) {
            $imageServer  = new Yesilcam\ImageServer($sizedImage);

//            Event::fire('image.serving',$sizedImage);
            return $imageServer->serve();
        }
        Debugbar::stopMeasure('render');
//        return View::make('hello');
    }

/*
 * TODO NOTES:
 * interface yada abstract class image yapıp iki tabloyu aynı formata getirip
 * eğer orjinal imajın orantılı hali varsa o orantılı halden kesme yapılabilir
 * Bunun dışında otomatik olarak büyük imajın çeşitli boyutlarda orantılı hali otomatik olarak kesilir
 * Böylece memoryden kazanır
 */


});





Route::get('scan', function()
{
    $scanner = new \Yesilcam\ImageScanner();

    $scanner->getValidFiles();

    dump($scanner->files);

    foreach($scanner->files as $key => $file) {

        $img = Yesilcam\ImageRepository::where('path',$file)->first();

        if($img) {
            continue;
        }

        dump( $scanner->fullPath($file) );

        $imagePath = $scanner->fullPath($file);

        $image = Image::make($imagePath);



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