<?php

Event::listen('image.serving', function($imageServer)
{

    $recorder = new Yesilcam\ImageRecorder($imageServer);

    $savedRecorder = $recorder->save();

//    dump($savedRecorder);

    $redis = Redis::connection();
    $redis->set('imgtest',date('H:i:s'));

});