<?php

$config['admin'] = array(

	// Name of the model for this data
	'model' => 'Forum_Model_Reply',

	// The table column names to show in the admin area
	'columns' => array(
		//'forum_id',
		'forum_topic_id',
		'user_id',
		'text',
		'status',
		'modified'
	),
	
);

return $config;