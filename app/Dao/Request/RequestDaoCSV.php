<?php

namespace App\Dao;

use App\Helper;
use App\Model\Request;

class RequestDaoCSV implements RequestDao {

	/**
	 * @param Request $request
	 *
	 * @return bool|mixed
	 */
	public function insertRequest( Request $request ) {

		$helper = Helper::getInstance();

		$helper->setDotenv();
		$helper->getDotenv()->load();

		if ( ! file_exists( './data' ) ) {
			if ( ! mkdir( './data', 0777, true ) ) {
				return false;
			}

			if ( $robots = fopen( './data/robots.txt', 'a' ) ) {
				file_put_contents( './data/robots.txt', "User-agent: *\nDisallow: /" );
			}

			fclose( $robots );
		}

		//Try to open the file pointer
		if ( ! $file_pointer = fopen( $_ENV['CSV_PATH'], 'a' ) ) {
			return false;
		}

		//Cast an object to an array
		$array = (array) $request;
		//This is the row will be written on csv for a request
		$row = [];

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