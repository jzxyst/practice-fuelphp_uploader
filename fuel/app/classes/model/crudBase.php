<?php
class Model_CrudBase extends Model_Crud
{
    public static function get_count() {
    	return DB::query(sprintf('SELECT COUNT(%s) AS count FROM %s', self::$_primary_key, self::$_table_name))->execute()->as_array();
    }
}
