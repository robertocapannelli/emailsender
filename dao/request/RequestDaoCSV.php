<?php

namespace Dao;

use Dotenv;

class RequestDaoCSV implements RequestDao {

	/**
	 * @param $request
	 *
	 * @return bool|mixed
	 */
	public function insertRequest( $request ) {

		/*TODO This should be called just once see other implementation in handlerequest class*/
		$dotenv = Dotenv\Dotenv::create( __DIR__ . "/../../" );
		$dotenv->load();

		$CSV_PATH = $_ENV['CSV_PATH'];

		//Try to open the file pointer
		if ( ! $file_pointer = fopen( $CSV_PATH, 'a' ) ) {
			return false;
		}

		//Cast an object to an array
		$array = (array) $request;
		//This is the row will be written on csv for a request
		$row   = [];

		//Get the request date
		$date = date( "Y-m-d H:i:s" );
		//Push the date in the row array
		array_push( $row, $date );

		//Compose the row from the object array
		foreach ( $array as $element ) {
			array_push( $row, $element );
		}

		//Try to put the row in the csv file
		if ( ! fputcsv( $file_pointer, $row ) ) {
			return false;
		}

		//Close the open file pointer
		fclose( $file_pointer );

		return true;

	}
}