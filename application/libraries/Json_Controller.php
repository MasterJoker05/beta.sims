<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Json_Controller extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->form_validation->set_error_delimiters("<span>", "</span><br>\n");
	}

}

/* End of file Json_Controller.php */
/* Location: ./application/controllers/Json_Controller.php */