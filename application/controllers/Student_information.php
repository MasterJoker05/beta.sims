<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student_information extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index() 
	{
		// $this->output->enable_profiler(TRUE);
		$this->data['content'] = 'Student\student_information';
		$this->load->view('template', $this->data);
	}

	public function edit($id = NULL) 
	{
		if($id == NULL)
		{
			dump("Add New");
		}
		else
		{
			dump("Edit Student");
		}
	}

}