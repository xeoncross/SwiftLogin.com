<?php

$config['admin'] = array(

	// Name of the model for this data
	'model' => 'Forum_Model_Topic',

	// The table column names to show in the admin area
	'columns' => array(
		//'forum_id',
		'forum_id',
		'user_id',
		'title',
		'status',
		'modified'
	),
	
);

return $config;