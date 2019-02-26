<?php

abstract class Controller_Base extends Controller
{
	protected $vars = array();

	public function before()
	{
		parent::before();

		$this->set_user_cookie();

		$this->vars += array(
			'base_url'	=> Uri::base(),
			'input' => Input::all(),
			'files_info' => [
				'total_file_size' => Model_Db_File::get_total_file_size()
			]
		);
	}

	private function set_user_cookie() {

		$cookie_name = 'userid';
		if (!Cookie::get($cookie_name, null)) {
			Cookie::set(
				$cookie_name,
				uniqid(),
				60 * 60 * 24 * 365 * 10,
				'/',
				null,
				true,
				true
			);
		}
	}
}
