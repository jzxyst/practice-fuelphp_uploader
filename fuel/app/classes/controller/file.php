<?php

use Fuel\Core\Profiler;
use Fuel\Core\Response;

class Controller_File extends Controller_Base
{

	public function action_index()
	{
		return Response::forge(null, Model_Const_Http_Status_Code::NOT_FOUND);
	}

	public function action_upload()
	{
		Model_File_Uploader::upload();

		return Response::redirect('/', 'location', Model_Const_Http_Status_Code::SEE_OTHER);
	}
}
