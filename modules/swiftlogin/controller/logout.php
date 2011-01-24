<?php

class Controller_Logout extends SwiftLogin_Controller
{
	/*
	 * Load a view that shows a welcome message
	 */
	function index()
	{
		
		// Start the user session
		Session::start(config('session'));
		
		// Send home
		redirect();
		
		// Kill it
		Session::destroy();
		
		// End
		exit();
	}
	
}
