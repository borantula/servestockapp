<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ImageScannerCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'servestock:scan';

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
		$scanner = new \Yesilcam\ImageScanner();

		$scanner->getValidFiles();

		$count = count($scanner->files);

		$this->info('Starting for image scanning and registering');
		$this->info($count .' Images Found');

		foreach($scanner->files as $key => $file) {

			$img = Yesilcam\ImageRepository::where('path',$file)->first();

			if($img) {
				$this->info("Already Registered: ".($key+1)." of {$count}: ".$file);
				continue;
			}


			$imagePath = $scanner->fullPath($file);

			$image = Image::make($imagePath);

			//register
			\Yesilcam\ImageScanner::registerImage( $file,$image->width(),$image->height() );

			$this->info("Registered: ".($key+1)." of {$count}: ".$file);

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
//			array('example', InputArgument::REQUIRED, 'An example argument.'),
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
//			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
