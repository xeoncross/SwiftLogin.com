<?php
class Controller_Welcome extends Controller
{
	public $template = 'thin_layout';
	
	public function index()
	{
		die('SwiftLogin');
		Session::start(config('session'));
		
		$this->sidebar = new View('sidebar', FALSE);
		$this->content = new View('index', 'swiftlogin');
	}
	
}