<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Curriculum extends MY_Controller {

	public $limit = 10;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Curriculum_m', 'curriculum_m');
		$this->data['page_title'] = "CURRICULUM";
		// dump($this->session->userdata());
		// exit();
	}

	public function index()
	{
		$this->output->enable_profiler(TRUE);


		$this->load->library('pagination');

		$search_arr = array();
		$this->data['options'] = $this->curriculum_m->options;

		if ($this->input->post('reset_button', TRUE) != NULL)
		{
			$this->session->unset_userdata('filter_result');
			$this->session->unset_userdata('filter_field');
			// redirection here to make sure that session are totally cleared
			return redirect('curriculum', 'refresh');
		}

		$search_arr = $this->session->userdata('filter_result');


		$search_arr && $this->db->where($search_arr, NULL, FALSE);
		$total_rows = $this->curriculum_m->count();

		$this->curriculum_m->search($this->pagination->offset, $this->limit);

		// $this->data['content'] = 'Student\form';
		// $this->load->view('template', $this->data);

		// Set up pagination
		$config['total_rows'] 	= $total_rows;
		$config['per_page'] 	= $this->limit;
		$this->pagination->initialize($config);


		// Retrieve paginated results, using the dynamically determined offset
		$this->db->limit($config['per_page'], $this->pagination->offset);

		// search conditions
		$search_arr && $this->db->where($search_arr, NULL, FALSE);

		// get results from db
		$this->db->order_by('tblcurriculum.CollegeId,tblcurriculum.CurriculumDesc', 'desc');
		$this->data['curriculums'] = $this->curriculum_m->get();

		// create pagination links 
		$this->data['pagination'] = $this->pagination->create_links();

		$this->data['search_arr'] = $this->session->userdata('filter_field');
		$this->data['search'] = get_key($this->data['search_arr'], 'search');
		$this->data['by'] = get_key($this->data['search_arr'], 'by', '');
		$this->load_view('curriculum/index');
	}

}

/* End of file Student_Evaluation.php */
/* Location: ./application/controllers/student_evaluation.php */