<?php

// URL to admin the table rows
$config['admin_url'] = site_url(url(0).'/admin');

// URL to edit table rows
$config['update_url'] =  site_url(url(0).'/update');

// URL to perform actions on table rows
$config['process_url'] =  site_url(url(0).'/process');

// Name of the model for this data
$config['model'] = '';

// The table column names to show in the admin area
$config['columns'] = array(
	//'id',
	//'title',
	//'text',
	//etc...
);

// Row actions to take
$config['actions'] = array(
	'disable'	=> array('name' => 'Disable', 'columns' => array('status' => 0)),
	'enable'	=> array('name' => 'Enable', 'columns' => array('status' => 1)),
	' ',
	'delete'	=> array('name' => 'Delete', 'delete' => TRUE),
);

// Number of rows to show per-page
$config['per_page'] = 10;

return $config;