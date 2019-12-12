<?php

namespace Dao;
use Model\Request;

interface RequestDao {
	/**
	 * Save the request in storage
	 *
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function insertRequest( Request $request );
}