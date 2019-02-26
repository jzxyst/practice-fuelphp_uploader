<?php

abstract class Controller_Api_Base extends Controller_Rest
{
	protected $vars = array();

	public function before()
	{
		parent::before();

		$this->vars += array(
			'base_url'	=> Uri::base(),
			'input' => Input::all()
		);
	}
}
