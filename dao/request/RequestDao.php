<?php

namespace Dao;

interface RequestDao {
	/**
	 * Save the request in storage
	 *
	 * @param $request
	 *
	 * @return mixed
	 */
	public function insertRequest( $request );
}