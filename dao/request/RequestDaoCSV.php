<?php

namespace Dao;

use Dotenv;

class RequestDaoCSV implements RequestDao {

	/**
	 * Insert a request in the CSV file
	 *
	 * @param $request
	 */
	public function insertRequest( $request ) {

		/*TODO This should be called just once see other implementation in handlerequest class*/
		$dotenv = Dotenv\Dotenv::create( __DIR__ . "/../../" );
		$dotenv->load();

		$CSV_PATH = $_ENV['CSV_PATH'];

		/*TODO this should throw an exception in case of failure or a logic*/
		$csv = fopen($CSV_PATH, 'a');

		$array = (array) $request;
		$line = [];

		foreach ($array as $element){
			array_push($line, $element);
		}

		fputcsv( $csv, $line );
		fclose($csv);
	}
}