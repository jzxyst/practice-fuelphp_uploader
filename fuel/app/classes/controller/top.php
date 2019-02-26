<?php

class Controller_Top extends Controller_Base
{
	private $pagination_config = [
		'total_items'    => 0,
		'per_page'       => 20,
		//'uri_segment'    => 1,
		'uri_segment'    => 'page',
		'show_first' => true,
		'show_last' => true
	];

	public function action_index()
	{Profiler::console(Date::time());
		$this->vars['files'] = [];

		// validation
		$validation = Model_Db_File::validate();
		if ($validation->run(Input::get())) {

			// pagination
			$this->pagination_config['total_items'] = Model_Db_File::get_valid_list_count(Input::get());
			$this->vars['pagination'] = Pagination::forge('default', $this->pagination_config);

			// ファイル取得
			$this->vars['files'] = Model_Db_File::get_valid_list($this->vars['pagination']->per_page, $this->vars['pagination']->offset, Input::get());
			foreach ((array)$this->vars['files'] as $file) {
				Model_File::set_attributes($file);
			}
		}

		return Response::forge(View_Smarty::forge('top/index.tpl', $this->vars));
	}
}
