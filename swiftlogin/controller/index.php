<?php
class Swiftlogin_Controller_Index extends Controller
{
	public $template = 'thin_layout';
	
	public function action()
	{
		//die('SwiftLogin');
		Session::start();
		
		$this->sidebar = new View('sidebar');
		$this->content = new View('index', 'swiftlogin');
	}
	
}