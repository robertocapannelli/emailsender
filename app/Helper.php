<?php


namespace App;

use Dotenv;

class Helper {
	private $dotenv;

	private static $instance = null;

	/**
	 * Helper constructor.
	 */
	public function __construct() {
	}

	/**
	 * Singleton
	 *
	 * @return Helper|null
	 */
	public static function getInstance() {
		if ( self::$instance == null ) {
			self::$instance = new Helper();
		}

		return self::$instance;
	}

	/**
	 * @return mixed
	 */
	public function getDotenv() {
		return $this->dotenv;
	}

	/**
	 * Set the dot environment
	 */
	public function setDotenv(): void {
		//TODO this always return uncaught
		try {
			$this->dotenv = Dotenv\Dotenv::create( dirname( __DIR__ ) );
		} catch ( Dotenv\Exception\InvalidPathException | Dotenv\Exception\InvalidFileException | Dotenv\Exception\ValidationException $e ) {
			echo $e->getMessage();
		}
	}
}