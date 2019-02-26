<?php
/*
 * prevの1ページ目URL作成
 * @params array $params url：URL
 */

function smarty_modifier_to_formatted_size($size)
{
	return Utility_Format::to_formatted_size($size);
}