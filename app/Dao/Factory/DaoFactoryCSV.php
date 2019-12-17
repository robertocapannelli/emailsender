<?php

namespace App\Dao;

class DaoFactoryCSV extends DaoFactory {

	public function getFactoryMethod(): RequestDao {
		return new RequestDaoCSV();
	}
}