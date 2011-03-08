<?php
class Domain_Controller_Process extends SwiftLogin_Admin
{
	public function action()
	{
		$config = config('admin','domain');

		// Run
		$this->process($config);
	}
}
