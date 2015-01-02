<?php

class ExampleTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testBasicExample()
	{
		$sizes = array('200/500','500/500','400/400','300/300','960/300','1200/800');

		foreach ($sizes as $key => $size) {
			for( $i = 0;$i <= 10;$i++ ) {

				$crawler = $this->client->request('GET', '/test/'.$size);

				$this->assertTrue($this->client->getResponse()->isOk());
			}
		}

	}

}
