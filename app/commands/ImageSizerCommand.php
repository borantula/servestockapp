<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ImageSizerCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'servestock:resize';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

		$id = $this->argument('id');
		$width = $this->option('width');
		$height = $this->option('height');

		//if no height, than it will be proportional
		$autoHeight = false;
		if( !$height ) {
			$autoHeight = true;
		}

		if( $id ) {

			$images = Yesilcam\ImageRepository::whereId($id)->get();
		} else {

			$images = Yesilcam\ImageRepository::all();
		}

		if(!$images) {
			$this->error('No image found');
			return false;
		}

		$count = $images->count();
		$this->info($count .' Images Found');


		foreach ($images as $key => $image) {

				if($autoHeight) {
					$this->info("Resizing to ratio");
					$height = round( ($width * 100 )/ ($image->ratio) );
				}

				$provider = new Yesilcam\ImageProvider\SelectedImageProvider($width, $height, $image);

				$sizedImageFactory = new Yesilcam\SizedImageFactory($provider);

				$sizedImage = $sizedImageFactory->find();

				$this->info("Resized: no:{$key} id: {$image->id} to  {$width}:{$height}");

		}

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('id', InputArgument::OPTIONAL, 'Id of the original image, all images if empty'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('width', 'w', InputOption::VALUE_REQUIRED, 'Width to resize.', null),
			array('height', null, InputOption::VALUE_OPTIONAL, 'Height to resize.', null),
		);
	}

}
