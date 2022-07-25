<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Program extends Admin_Controller {

	public $limit = 10;

	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->library('user_agent');

		$this->load->model(['program_m','college_m']);
		$this->data['page_title'] = "PROGRAM";
		
		
	}

	public function index()
	{

		 $this->output->enable_profiler(TRUE);

		$this->load->library('pagination');

		if ($this->input->post('submit') == 'reset') {
			$this->session->unset_userdata('filter_result');
			redirect('program','refresh');
		}

		$search_arr = array();
		$this->data['options'] = $this->program_m->options;

		$this->program_m->search($this->pagination->offset, $this->limit);

		$search_arr = $this->session->userdata('filter_result');

		$search_arr && $this->db->where($search_arr, NULL, FALSE);
		
		$this->db->join('tblcollege as A','A.CollegeId = tblprogram.CollegeId','left');
		$total_rows = $this->program_m->count();

		// Set up pagination
		$config['total_rows'] 	= $total_rows;
		$config['per_page'] 	= $this->limit;
		$this->pagination->initialize($config);


		// Retrieve paginated results, using the dynamically determined offset
		$this->db->limit($config['per_page'], $this->pagination->offset);

		// search conditions
		$search_arr && $this->db->where($search_arr, NULL, FALSE);

		// get results from db
		$this->db->join('tblcollege as A','A.CollegeId = tblprogram.CollegeId','left');
		$this->data['programs'] = $this->program_m->get();

		// create pagination links 
		$this->data['pagination'] = $this->pagination->create_links();

		$this->data['javascript'] = 'program/javascript';
		$this->data['search_arr'] = $this->session->userdata('filter_field');
		$this->data['search'] = get_key($this->data['search_arr'], 'search');
		$this->data['by'] = get_key($this->data['search_arr'], 'by', '');

		$this->load_view('program/index');

	}

	

	public function form($id = NULL)
	{

		$method = 'get_new';

		if (intval($id) !== 0)
		$method = 'get';

		$this->data['college_options'] = $this->college_m->dropdown();
		$this->data['program'] = $this->program_m->$method($id);
		$this->data['formUrl'] = "program/confirm/{$id}";
		// to avoid invalid $id
		if (empty($this->data['program'])) 
		{
			$json['html'] = "<div class='alert alert-danger'>
								<strong>Invalid input. Access denied.</strong>
							</div>";
		}
		else
		{
			$json['html']    = $this->load->view('program/form', $this->data, TRUE);
		}
			

		return $this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function confirm($id = NULL)
	{
		$this->data['formUrl'] = "program/store/{$id}";
		
		$this->data['college_options'] = $this->college_m->dropdown();

		$validation = $this->program_m->validation();
		if ($validation !== TRUE)
		{
			return self::form($id);
		}

		! empty($programId) && $this->data['formUrl'] .= '/' . $id;
		$json['html'] = $this->load->view('program/confirm', $this->data, TRUE);
		return $this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function store($id = NULL) 
	{

		if ( ! $this->input->post())
		return FALSE;
		
		$rules = $this->program_m->rules;
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE)
		{
			$post = $this->program_m->array_from_post(array_keys($rules));

			$id = $this->program_m->save($post, $id);

			$data = [
				'success' => '<strong>Success</strong>. Record has been successfully saved'
			];
		}
		else
		{
			$data = [
				'error' => '<strong>Error</strong>. <p>' . validation_errors() . '</p>'
			];
		}

		return parent::redirect_with('program', $data);
	}


	public function _unique_code($value)
	{
		$id = $this->uri->segment(3);

		! empty($id) && $this->db->where('ProgramId !=', $id);
		$program = $this->program_m->get_by(['ProgramCode' => $value]);

		if ( ! empty($program))
		{
			$this->form_validation->set_message('_unique_code', "The %s field is already exists. " .$this->db->last_query());
			return FALSE;
		}

		return TRUE;

	}

	public function _unique_name($value)
	{
		$id = $this->uri->segment(3);

		! empty($id) && $this->db->where('ProgramId !=', $id);
		$program = $this->program_m->get_by(['ProgramDesc' => $value]);

		if ( ! empty($program))
		{
			$this->form_validation->set_message('_unique_name', "The %s field is already exists. " .$this->db->last_query());
			return FALSE;
		}

		return TRUE;
	}

	public function _unique_id($value)
	{
		$id = $this->uri->segment(3);

		! empty($id) && $this->db->where('ProgramId !=', $id);
		$program = $this->program_m->get_by(['CollegeId' => $value]);

		if ( ! empty($program))
		{
			$this->form_validation->set_message('_unique_id', "The %s field is already exists. " .$this->db->last_query());
			return FALSE;
		}

		return TRUE;
	}



}

/* End of file Program.php */
/* Location: ./application/controllers/Program.php */