<?php
//class Model_File extends Model_CrudBase
class Model_File_Uploader extends Model
{
	// アップロード設定
	private static $mConfig = [
		'create_path'   => true,
		'path_chmod'    => 0777,
		'file_chmod'    => 0666,
		'max_size'  =>  1500000000,
		'path' => \Constant\Server::UPLOAD_LOCAL_DIR,
//		'randomize' => true,
		'auto_rename'   => true,
		'ext_blacklist' => ['php', 'exe', 'cgi', 'pl', 'rb', 'py']
	];

	private static $file_unique_code_map = [];

	public static function upload(&$new_rows)
	{
		// プロセス実行
		Upload::process(Model_File_Uploader::$mConfig);

		// エラーチェック
		if (Upload::is_valid()) {

			$files = Upload::get_files();
			foreach ($files as $index => $file) {

				// 保存Pathを生成
				$unique_code = self::generate_unique_code();
				self::$file_unique_code_map[$index] = $unique_code;
				$save_path = \Constant\Server::UPLOAD_LOCAL_DIR . DS . $unique_code;

				// ファイルをローカルに保存
				Upload::save($index, $save_path);
			}


		} else {
			return self::create_error_response(Model_Const_Http_Status_Code::UNSUPPORTED_MEDIA_TYPE, Upload::get_errors());
		}

		$files = Upload::get_files();

		if (count($files) == 0) {
			return self::create_error_response(Model_Const_Http_Status_Code::INTERNAL_SERVER_ERROR);
		}

		foreach ($files as $index => $file)
		{
			$newRecord = Model_Db_File::forge([
				'unique_code'       => self::$file_unique_code_map[$index],
				'filename'			=> $file['saved_as'],
				'original_filename'	=> $file['name'],
				'file_size'			=> $file['size'],
				'mimetype'			=> $file['mimetype'],
				'comment'			=> Input::post('comment'),
				'delete_key'		=> Input::post('password') != '' ? Input::post('password') : null,
				'user_unique_id'    => Cookie::get('userid', ''),
				'user_ip_address'	=> Input::real_ip()
			]);

			$newRecord->save();

			// データ再取得
			$newRecord = Model_Db_File::find_by_pk($newRecord['upload_file_id']);

			$new_rows[] = $newRecord;
		}

		return Model_Const_Http_Status_Code::CREATED;
	}

	public static function delete($upload_file_id, $delete_key = '')
	{

		if ($upload_file_id <= 0) {
			return Model_Const_Http_Status_Code::BAD_REQUEST;
		}

		$file = Model_Db_File::find_by_pk($upload_file_id);

		// ファイル存在チェック
		if ($file) {
			if ($delete_key === $file['delete_key']) {

				// ファイルを削除
				$path = Model_File::get_file_local_path($file);
				if (unlink($path)) {
					// DBから削除
					$file->delete();
				} else {
					return Model_Const_Http_Status_Code::INTERNAL_SERVER_ERROR;
				}

				return Model_Const_Http_Status_Code::NO_CONTENT;
			} else {
				// delete_keyが不一致
				return Model_Const_Http_Status_Code::UNAUTHORIZED;
			}
		} else {
			// リソースなし
			return Model_Const_Http_Status_Code::NOT_FOUND;
		}
	}

	public static function generate_unique_code()
	{
		return uniqid();
//		return md5(uniqid(rand(),1));
	}

	private static function create_error_response($status_code, $errors = [])
	{
		return [$status_code, $errors];
	}
}
