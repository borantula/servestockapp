<?php

use \Yesilcam;

class ImageProcessorTest extends TestCase {

    /** @test */
    public function itChecksForFolder ()
    {
        $scanner = new \Yesilcam\ImageScanner();

        $this->assertTrue( $scanner->folderExists() );

    }



}
 