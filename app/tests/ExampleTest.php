<?php

class ExampleTest extends TestCase
{

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        return;
        $sizes = array('200/500', '500/500', '150/150', '960/300', '1200/800');


        foreach ($sizes as $key => $size) {
            for ($i = 0; $i <= 10; $i++) {

                $crawler = $this->client->request('GET', '/test/' . $size);

                $this->assertTrue($this->client->getResponse()->isOk());
            }
        }

    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testAllImages()
    {

        $sizes = array(
            [728, 90],
            [468, 60],
            [320, 50],
            [300, 100],
            [300, 50],
            [234, 60],
            [300, 600],
            [160, 600],
            [120, 600],
            [240, 400],
            [120, 240],
            [336, 280],
            [300, 250],
            [250, 250],
            [200, 200],
            [180, 150],
            [125, 125],
            [120, 90],
            [120, 60],
            [88, 31],
            [500, 500],
            [160, 160],
            [176, 208],
            [240, 320],
            [320, 240],
            [320, 320],
            [352, 416],
            [416, 352],
            [320, 480],
            [480, 320],
            [320, 416],
            [480, 268],
            [320, 480],
            [960, 640],
            [1136, 640],
        );

        $sizes = [
            [500, 500],
            [160, 160],
            [728, 90],
            [468, 60],
            [300, 600],
        ];

        $images = Yesilcam\ImageRepository::all();

        foreach ($images as $key => $image) {
            foreach ($sizes as $key => $size) {


                $provider = new Yesilcam\ImageProvider\SelectedImageProvider($size[0], $size[1], $image);

                $sizedImageFactory = new Yesilcam\SizedImageFactory($provider);

                $sizedImage = $sizedImageFactory->find();

                $this->assertNotEmpty($sizedImage);
            }
        }

    }

}
