<?php
// Deny Access
class SwiftLogin_Controller_Deny extends Controller
{
	public function action($return_to = NULL)
	{
		$this->content = new View('deny','swiftlogin');
	}
}