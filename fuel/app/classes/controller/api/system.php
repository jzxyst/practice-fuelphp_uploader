<?php

/**
 * Class Controller_Api_System
 */
class Controller_Api_System extends Controller_Api_Base
{
	/**
	 * @return mixed
	 */
	public function get_deploy()
	{
		return $this->post_deploy();
	}

	/**
	 * @return mixed
	 */
	public function post_deploy()
	{
		$output = '';
		$return_code = '';
		$stdout = exec(sprintf('sh %s', APPPATH . '../../batch/deploy.sh'), $output, $return_code);

		$response = [
			'stdout' => $stdout,
			'output' => $output,
			'return_code' => $return_code
		];

		return $this->response($response);
	}

	/**
	 * @return mixed
	 */
	public function get_phpinfo()
	{
		return phpinfo();
	}
}
