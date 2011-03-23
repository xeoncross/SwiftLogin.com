<?php

class About_Controller_Privacy extends SwiftLogin_Controller
{
	public function action()
	{
		Session::start();
		
		$this->sidebar = new View('sidebar');
		$this->content = new View('privacy', 'about');
	}
}
