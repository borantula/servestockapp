<?php

Event::listen('image.serving', function(\Yesilcam\ImageBase $sizedImage)
{

    $names = $sizedImage->namer();
    $redis = Redis::connection();
    $redis->incr($names['serve_count']);

});