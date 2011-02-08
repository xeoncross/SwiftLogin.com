<?php

class Account_Controller_Logout extends SwiftLogin_Controller
{
	/*
	 * Load a view that shows a welcome message
	 */
	function action($return_to = NULL)
	{
		
		// Start the user session
		Session::start();
		
		// Send home
		redirect($return_to ? base64_url_decode($return_to) : '');
		
		// Kill it
		Session::destroy();
		
		// End
		exit();
	}
	
}
