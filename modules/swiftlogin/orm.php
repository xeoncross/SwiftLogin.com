<?php

class Emaillogin_ORM extends ORM
{

	protected function insert(array $data)
	{
		$time = new Time();
		$data['created'] = $time->getSQL();
		return parent::insert($data);
	}

}