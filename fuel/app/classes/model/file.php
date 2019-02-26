<?php
/**
 * Created by PhpStorm.
 * User: ***
 * Date: 2017/02/22
 * Time: 11:18
 */
class Model_File extends Model
{
	protected static $mimetype_awesome_class_map = [
		'_default_' => 'fa-file-o',
		'application/zip' => 'fa-file-archive-o',
		'application/x-rar-compressed' => 'fa-file-archive-o',
		'audio' => 'fa-file-audio-o',
		'video' => 'fa-file-video-o',
		'image' => 'fa-file-image-o',
		'text' => 'fa-file-text-o',
		'application/pdf' => 'fa-file-pdf-o',
	];

	public static function get_file_url($file)
	{
		$url = sprintf('%sfiles/%s/%s', Uri::base(), $file['unique_code'], $file['filename']);

		return $url;
	}

	public static function get_file_local_path($file)
	{
		$path = sprintf('%s/%s/%s', \Constant\Server::UPLOAD_LOCAL_DIR, $file['unique_code'], $file['filename']);

		return $path;
	}

	public static function set_attributes(&$file)
	{
		$file['content_url'] = Model_File::get_file_url($file);
		$file['file_size_with_unit'] = Utility_Format::to_formatted_size($file['file_size']);
		$file['mimetype_awesome_class'] = self::get_awesome_class($file['mimetype']);
	}

	public static function remove_unsecure_attributes(&$file)
	{
		// 不必要なカラムを除去
		unset($file['delete_key']);
		unset($file['user_ip_address']);
		unset($file['file_status']);
		unset($file['modified_datetime']);
	}

	public static function get_awesome_class($mimetype)
	{
		// 検索対象文字列
		$target_words = array_merge(
			[$mimetype],
			explode('/', $mimetype)
		);

		// 完全一致を検索
		foreach ($target_words as $target_word) {
			foreach (self::$mimetype_awesome_class_map as $mimetype_pattern => $awesome_class) {
				if ($target_word === $mimetype_pattern) {
					return $awesome_class;
				}
			}
		}

		return self::$mimetype_awesome_class_map['_default_'];
	}
}