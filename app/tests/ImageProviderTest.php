<?php


class ImageProviderTest extends TestCase {


    /**
     * @test
     * @dataProvider validResults
     * @param $width
     * @param $height
     */
    public function itSearchesForImages ($width,$height)
    {
        parent::createApplication();
        $provider = new Yesilcam\ImageProvider();

        $result = $provider->search($width,$height);

        $this->assertNotEmpty($result);


    }


    public function validResults()
    {
        return array(
            array(100,400),
            array(400,400),
            array(1021,1231)
        );
    }

}
 