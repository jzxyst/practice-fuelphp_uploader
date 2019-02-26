<?php
/**
 * Created by PhpStorm.
 * User: ***
 * Date: 2017/10/10
 * Time: 14:57
 */

class Utility_Archive
{
	/**
	 * @param array $src_paths
	 * @param string $dest_path
	 * @param int $mode
	 * @throws Exception
	 */
	public static function to_zip(array $src_paths, string $dest_path, int $mode = 0755) {

		$zip = new \ZipArchive();

		if ($res = $zip->open($dest_path, \ZipArchive::CREATE) !== true) {
			throw new Exception("Zip create error. ZipArchive error code : " . (string)$res);
		}

		foreach ($src_paths as $src_path) {

			if ($zip->addFile($src_path, basename($src_path)) == false) {
				$zip->close();
				throw new Exception("Zip create error. ZipArchive error file : ".(string)$src_path);
			}
		}

		$zip->close();

		chmod($dest_path, $mode);

		return;
	}
}