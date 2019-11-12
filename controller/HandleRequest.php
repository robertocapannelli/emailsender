<?php

namespace Controller;

use Model\Request;

class HandleRequest {

	private $request;

	/**
	 * Create a request from user data
	 *
	 * @TODO this should validate and sanitize data
	 *
	 * @param $name
	 * @param $email
	 * @param $phone
	 *
	 * @return Request
	 */
	public function createRequest( $name, $email, $phone ) {

		if ( ! empty( $name ) && ! empty( $email ) && ! empty( $phone ) ) {
			$name  = filter_var( trim( $name ), FILTER_SANITIZE_STRING );
			$email = filter_var( trim( $email ), FILTER_SANITIZE_EMAIL );
			$phone = filter_var( trim( $phone ), FILTER_SANITIZE_NUMBER_INT );
		} else {
			return null;
		}

		$this->request = new Request( $name, $email, $phone );

		return $this->request;
	}

}