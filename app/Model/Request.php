<?php

namespace App\Model;


class Request {

	private $name;
	private $email;
	private $phone;
	private $file;

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
	 * @return mixed
	 */
	public function getFile() {
		return $this->file;
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

	/**
	 * @param $file
	 */
	public function setFile( $file ) {
		$this->file = $file;
	}

}