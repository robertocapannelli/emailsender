<?php

namespace Model;


class Request {

	private $name;
	private $email;
	private $phone;

	/**
	 * Request constructor.
	 *
	 * @param $name
	 * @param $email
	 * @param $phone
	 */
	public function __construct( $name, $email, $phone ) {
		$this->name  = $name;
		$this->email = $email;
		$this->phone = $phone;
	}


	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName( $name ) {
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param mixed $email
	 */
	public function setEmail( $email ) {
		$this->email = $email;
	}

	/**
	 * @return mixed
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * @param mixed $phone
	 */
	public function setPhone( $phone ) {
		$this->phone = $phone;
	}



}