<?php

namespace Controller;

use Model\Request;

class HandleRequest {

	private $request;

	/**
	 * Create a request from user data
	 *
	 * @TODO this should validate and sanitize data
	 * @param $name
	 * @param $email
	 * @param $phone
	 *
	 * @return Request
	 */
	public function createRequest( $name, $email, $phone) {
		$this->request = new Request( $name, $email, $phone );

		return $this->request;
	}

}