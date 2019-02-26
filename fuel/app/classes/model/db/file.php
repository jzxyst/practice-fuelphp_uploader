<?php

/**
 * Class Model_Db_File
 */
class Model_Db_File extends Model_Crud
{
	//使用するtable
	protected static $_table_name = 'upload_file';

	//プライマリキー
	protected static $_primary_key = 'upload_file_id';

	//データ検証用のルール
	protected static $_rules = array(
	);

	//値未設定時のデフォルト値
	protected static $_defaults = array(
	);

	protected static $_default_config = [
		'limit' => 30,
		'offset' => 0
	];

	/**
	 * @param int $limit
	 * @param int $offset
	 * @param $conditions
	 * @return mixed
	 */
	public static function get_valid_list($limit = 30, $offset = 0, $conditions = []) {

		$limit = $limit == null ? self::$_default_config['limit'] : $limit;
		$offset = $offset == null ? self::$_default_config['offset'] : $offset;

		// 有効なファイルのみ取得
		$files = self::find(function($query) use ($limit, $offset, $conditions){

			$query->where('file_status', '=', 1);
			self::set_where($query, $conditions);
			$query->order_by('upload_file_id', 'desc');
			$query->limit($limit);
			$query->offset($offset);

			return $query;
		});

		return $files;
	}

	/**
	 * @return mixed
	 */
	public static function get_valid_list_count($conditions = []) {

		// 有効なファイルのみ取得
		$count = self::count(null, false, function($query) use ($conditions){

			$query->where('file_status', '=', 1);
			self::set_where($query, $conditions);

			return $query;
		});

		return $count;
	}

	/**
	 * @param int $limit
	 * @param int $offset
	 * @param $conditions
	 * @return mixed
	 */
	public static function get_mimetype_list() {

		// 有効なファイルのみ取得
		$files = self::find(function($query) {

			$query->where('file_status', '=', 1);
			$query->group_by('mimetype');
			$query->order_by('mimetype', 'asc');

			return $query;
		});

		return $files;
	}

	/**
	 * @return mixed
	 */
	public static function get_total_file_size() {

		// 有効なファイルのみ取得
		$files = self::find(function($query) {

			$query->select(\DB::expr('SUM(file_size) AS file_size'));
			$query->where('file_status', '=', 1);

			return $query;
		});

		return $files[0]['file_size'];
	}

	/**
	 * @return mixed
	 */
	public static function validate() {

		$validation = Validation::instance();
		$validation->add_callable('Validation_Extension');

		$validation->add('limit', 'limit')
			->add_rule('not_null')
			->add_rule('valid_string', array('numeric'))
			->add_rule('numeric_min', 1);

		return $validation;
	}

	/**
	 * @param $query
	 * @param $conditions
	 */
	public static function set_where(&$query, $conditions) {

		// MIMEType
		if (array_key_exists('mimetype', $conditions) && $conditions['mimetype'] !== '') {
			if (preg_match('/\/$/', $conditions['mimetype'])) {
				$query->where('mimetype', 'LIKE', "{$conditions['mimetype']}%");
			} else {
				$query->where('mimetype', '=', $conditions['mimetype']);
			}
		}

		// use cookie
		if (array_key_exists('is_only_mine', $conditions) && $conditions['is_only_mine'] !== '') {
			$query->where('user_unique_id', '=', Cookie::get('userid', ''));
		}

		// フリーワード検索
		if (array_key_exists('freeword', $conditions) && $conditions['freeword'] !== '') {
			$query->and_where_open()
				->where('original_filename', 'LIKE', "%{$conditions['freeword']}%")
				->or_where('comment', 'LIKE', "%{$conditions['freeword']}%")
				->and_where_close();
		}
	}
}
