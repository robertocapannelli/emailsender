<?php

namespace App\Dao;

use App\Model\Request;

interface RequestDao {
	/**
	 * Save the request in storage
	 *
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function insert( Request $request );
}