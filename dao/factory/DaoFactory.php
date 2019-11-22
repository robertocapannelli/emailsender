<?php


namespace Dao;

abstract class DaoFactory {

	abstract public function getFactoryMethod(): RequestDao;

	/**
	 * Get the right data access object to save the request
	 *
	 * @param $request
	 *
	 * @return mixed
	 */
	public function getDaoFactory( $request ) {
		return $this->getFactoryMethod()->insertRequest( $request );
	}
}