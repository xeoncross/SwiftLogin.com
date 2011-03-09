<?php

// Admin settings
$config['admin'] = array(

	// Name of the model for this data
	'model' => 'Swiftlogin_Model_Domain',

	// The table column names to show in the admin area
	'columns' => array(
		'domain',
		'banned',
		'ignore',
		'created'
	),

	// Row actions to take
	'actions' => array(
		'unban'	=> array('name' => 'Un-Ban', 'columns' => array('banned' => 0)),
		'ban'	=> array('name' => 'Ban', 'columns' => array('banned' => 1)),
		' ',
		'un-ignore'	=> array('name' => 'Un-Ignore', 'columns' => array('ignore' => 0)),
		'ignore'	=> array('name' => 'Ignore API requests', 'columns' => array('ignore' => 1)),
		' ',
		'delete'	=> array('name' => 'Delete', 'delete' => TRUE),
	)
	
);

return $config;