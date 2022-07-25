<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course extends Admin_Controller {

	public $limit = 10;

	public function __construct()
	{
		parent::__construct();

		$this->load->model(['course_m']);
		$this->data['page_title'] = "Course";
	}

	public function index()
	{
		// Load the profiler
		$this->output->enable_profiler(TRUE);

		//Pagination

		$total_rows = $this->course_m->count();
		$this->load->library('pagination');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $this->limit;
		$this->pagination->initialize($config);

		//Retrieve pagination results
		$this->db->limit($config['per_page'], $this->pagination->offset);

		//create pagination links
		$this->data['pagination'] = $this->pagination->create_links();

		// Get value of Search by and Search Field
		$option = $this->input->post('option');
		$search = $this->input->post('Search');

		//reset button
		if ($this->input->post('submit') == 'reset') {
			$this->session->unset_userdata('filter_result');
			rediret('course', 'refresh');
		}

		echo $option;
		echo $search;

		// Limit the data
		// $this->db->limit(5);

		
		// Condition to check if the value of option and search fields is not empty 
		if (!empty($option) && !empty($search)) {
			$this->db->like($option, $search);


		} 
		

		// Get Data from database
		$courses = $this->course_m->get();

		// Pass data to view
		$this->data['course'] = $courses ;
		
		// Load the view index.php
		$this->load_view('course/index');

		



	}
}




































/* End of file College.php */
/* Location: ./application/controllers/College.php */