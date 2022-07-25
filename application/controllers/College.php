<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class College extends Admin_Controller {

	public $limit = 10;

	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->library('user_agent');

		$this->load->model('College_m', 'college_m');
		$this->data['page_title'] = "COLLEGES";
	}

	public function index()
	{
		$this->output->enable_profiler(TRUE);


		$this->load->library('pagination');

		$search_arr = array();
		$this->data['options'] = $this->college_m->options;

		$this->college_m->search($this->pagination->offset, $this->limit);

		$search_arr = $this->session->userdata('filter_result');


		$search_arr && $this->db->where($search_arr, NULL, FALSE);
		$total_rows = $this->college_m->count();



		// Set up pagination
		$config['total_rows'] 	= $total_rows;
		$config['per_page'] 	= $this->limit;
		$this->pagination->initialize($config);


		// Retrieve paginated results, using the dynamically determined offset
		$this->db->limit($config['per_page'], $this->pagination->offset);

		// search conditions
		$search_arr && $this->db->where($search_arr, NULL, FALSE);

		// get results from db
		$this->data['colleges'] = $this->college_m->get();

		// create pagination links 
		$this->data['pagination'] = $this->pagination->create_links();

		$this->data['javascript'] = 'college/javascript';
		$this->data['search_arr'] = $this->session->userdata('filter_field');
		$this->data['search'] = get_key($this->data['search_arr'], 'search');
		$this->data['by'] = get_key($this->data['search_arr'], 'by', '');

		$this->load_view('college/index');

	}

	

	public function form($id = NULL)
	{

		$method = 'get_new';

		if (intval($id) !== 0)
		$method = 'get';

		$this->data['college'] = $this->college_m->$method($id);
		$this->data['formUrl'] = "college/confirm/{$id}";
		// to avoid invalid $id
		if (empty($this->data['college'])) 
		{
			$json['html'] = "<div class='alert alert-danger'>
								<strong>Invalid input. Access denied.</strong>
							</div>";
		}
		else
		{
			$json['html'] = $this->load->view('college/form', $this->data, TRUE);
		}
			

		return $this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function confirm($id = NULL)
	{
		$this->data['formUrl'] = "college/store/{$id}";

		$validation = $this->college_m->validation();
		
		if ($validation !== TRUE)
		{
			return self::form($id);
		}

		! empty($collegeId) && $this->data['formUrl'] .= '/' . $id;
		$json['html'] = $this->load->view('college/confirm', $this->data, TRUE);
		return $this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function store($id = NULL) 
	{

		if ( ! $this->input->post())
		return FALSE;
		
		$rules = $this->college_m->rules;
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE)
		{
			$post = $this->college_m->array_from_post(array_keys($rules));

			$id = $this->college_m->save($post, $id);

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

		return parent::redirect_with('college', $data);
	}


	public function _unique_code($value)
	{
		$id = $this->uri->segment(3);

		! empty($id) && $this->db->where('CollegeId !=', $id);
		$college = $this->college_m->get_by(['CollegeCode' => $value]);

		if ( ! empty($college))
		{
			$this->form_validation->set_message('_unique_code', "The %s field is already exists. " .$this->db->last_query());
			return FALSE;
		}

		return TRUE;

	}

	public function _unique_name($value)
	{
		$id = $this->uri->segment(3);

		! empty($id) && $this->db->where('CollegeId !=', $id);
		$college = $this->college_m->get_by(['CollegeDesc' => $value]);

		if ( ! empty($college))
		{
			$this->form_validation->set_message('_unique_name', "The %s field is already exists. " .$this->db->last_query());
			return FALSE;
		}

		return TRUE;
	}



}

/* End of file College.php */
/* Location: ./application/controllers/College.php */