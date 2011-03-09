<?php

//Choice of "config" or "db"
$config['default_role']	= 9;

//An array describing the role relationships
$config['roles'] = array(
	//ID	Parent_ID	Name
	1 	=> 'admin',			//Manage everything
	2	=> 'manager',		//Manage most aspects of the site
	3	=> 'editor',		//Scheduling and managing content
	4	=> 'author',		//Write important content
	5	=> 'contributor',	//Authors with limited rights
	6	=> 'moderator',		//Moderate users and their content
	7	=> 'member',		//Special user access
	8	=> 'subscriber',	//Paying Average Joe
	9	=> 'user',			//Average Joe
);

// User Model
$config['admin'] = array(

	// Name of the model for this data
	'model' => 'Swiftlogin_Model_User',

	// The table column names to show in the admin area
	'columns' => array(
		//'forum_id',
		'email',
		'domain_id',
		'role_id',
		'timezone',
		'activation_key',
		'banned',
		'created'
	),

	// Row actions to take
	'actions' => array(
		'unban'	=> array('name' => 'Un-ban', 'columns' => array('banned' => 0)),
		'ban'	=> array('name' => 'Ban', 'columns' => array('banned' => 1)),
		' ',
		'delete'	=> array('name' => 'Delete', 'delete' => TRUE),
	)
	
);

return $config;