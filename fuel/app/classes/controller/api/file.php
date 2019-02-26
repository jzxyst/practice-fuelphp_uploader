<?php

/**
 * Class Controller_Api_File
 */
class Controller_Api_File extends Controller_Api_Base
{

	/**
	 * @return mixed
	 */
	public function get_list()
	{
		// validation
		$validation = Model_Db_File::validate();
		if (!$validation->run(Input::get())) {
			return Response::forge(null, Model_Const_Http_Status_Code::BAD_REQUEST);
		}

		// DBからデータを取得
		$files = Model_Db_File::get_valid_list(Input::get('limit'), Input::get('offset'), Input::get());

		foreach ((array)$files as $file) {
			// attributesを設定
			Model_File::set_attributes($file);

			// 不必要なカラムを除去
			Model_File::remove_unsecure_attributes($file);

			if (Input::get('template')) {
				$file['template'] = View_Smarty::forge(Input::get('template'), array_merge($this->vars, ['_file' => $file]))->render();
			}
		}

		return $this->response($files);
	}

	/**
	 * @return mixed
	 */
	public function post_upload()
	{
		$new_files = [];
		[$status_code, $details] = Model_File_Uploader::upload($new_files);

		foreach ($new_files as $file) {
			// attributesを設定
			Model_File::set_attributes($file);

			// 不必要なカラムを除去
			Model_File::remove_unsecure_attributes($file);

			$file['template'] = View_Smarty::forge('include/file_row.tpl', array_merge($this->vars, ['_file' => $file]))->render();
		}

		return $this->response(count($new_files) > 0 ? $new_files : $details, $status_code);
	}

	/**
	 * @return mixed
	 */
	public function delete_file()
	{
		$response_code = Model_File_Uploader::delete(Input::get('upload_file_id'), Input::get('delete_key'));

		return Response::forge(null, $response_code);
	}

	/**
	 * @return mixed
	 */
	public function get_total()
	{
		// DBからデータを取得
		$total_file_size = Model_Db_File::get_total_file_size();

		$response = [
			'total_file_size' => [
				'value' => $total_file_size,
				'label' => Utility_Format::to_formatted_size($total_file_size)
			]
		];

		return $this->response($response);
	}
}
