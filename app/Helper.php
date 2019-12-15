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
		$this->dotenv = Dotenv\Dotenv::create( dirname( __DIR__ ) );
	}
}