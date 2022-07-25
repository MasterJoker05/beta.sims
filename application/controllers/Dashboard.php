<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Admin_Controller {


	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->library('user_agent');

		$this->data['page_title'] = "DASHBOARD";
	}

	public function index()
	{
		$this->output->enable_profiler(TRUE);

		$this->load_view('dashboard/index');

	}



}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */