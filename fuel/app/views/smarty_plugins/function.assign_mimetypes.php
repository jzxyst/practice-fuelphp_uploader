<?php
/*
 * prevの1ページ目URL作成
 * @params array $params url：URL
 */

function smarty_function_assign_mimetypes($params, $template)
{
	$list = Model_Db_File::get_mimetype_list();

	$template->assign(isset($params['var']) ? $params['var'] : 'mimetypes', $list);
}