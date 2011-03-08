<?php
class Reply_Controller_Process extends SwiftLogin_Admin
{
	public function action()
	{
		$config = config('admin','reply');

		// Run
		$this->process($config);
	}
}
