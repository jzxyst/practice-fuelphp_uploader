<?php
return array(
	'extensions' => array(
		'tpl'    => 'View_Smarty',
	),

	'View_Smarty'   => array(
		'environment'   => array(
			'plugins_dir'  => array(APPPATH.'views'.DS.'smarty_plugins')
		),
	),
);
