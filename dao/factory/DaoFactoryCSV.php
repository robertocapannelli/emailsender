<?php

namespace Dao;

class DaoFactoryCSV extends DaoFactory {

	public function getFactoryMethod(): RequestDao {
		return new RequestDaoCSV();
	}
}