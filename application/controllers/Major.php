<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Major extends Admin_Controller {
	
	public $limit = 10;
	
	public function __construct()
	{
		parent::__construct();
//new
		$this->load->library('form_validation');
		$this->load->library('user_agent');
		$this->load->model(['major_m','program_m','college_m']);
		$this->data['page_title']="MAJOR";
	}

	public function index()
	{
		$this->output->enable_profiler(TRUE);

		$this->load->library('pagination');

		$search_arr=array();
		$this->data['options']=$this->major_m->options;

		// if ($this->input->post('reset_button', TRUE)!= NULL);
		// {
		// 	$this->session->unset_userdata('filter_result');
		// 	$this->session->unset_userdata('filter_field');
		// 	// redirection here to make sure that session are totally cleared
		// 	// return redirect('major', 'refresh');
		// }

		if ($this->input->post('submit') == 'reset') {
			$this->session->unset_userdata('filter_result');
			redirect('major','refresh');
		}

		$this->major_m->search($this->pagination->offset, $this->limit);

		$search_arr=$this->session->userdata('filter_result');
		// dump($search_arr);
		$search_arr && $this->db->where($search_arr, NULL, FALSE);
		$this->db->join('tblprogram as A','A.ProgramId = tblmajor.ProgramId','left');
		$total_rows = $this->major_m->count();


		//setup pagination
		$config['total_rows'] = $total_rows;
		$config['per_page']   = $this->limit;
		$this->pagination->initialize($config);


		// Retrieve paginated results, using the dynamically determined offset
		$this->db->limit($config['per_page'],$this->pagination->offset);

		// search conditions
		$search_arr && $this->db->where($search_arr, NULL, FALSE);

		// // get results from db
		$this->db->join('tblprogram as A','A.ProgramId = tblmajor.ProgramId','left');
		$this->data['majors'] = $this->major_m->get();
		
		// // create pagination links 
		$this->data['pagination'] = $this->pagination->create_links();

		$this->data['javascript'] = 'major/javascript';
		$this->data['search_arr'] = $this->session->userdata('filter_field');
		$this->data['search'] = get_key($this->data['search_arr'], 'seach');
		$this->data['by'] = get_key($this->data['search_arr'],'by', '');

		$this->load_view('major/index');

	}


	public function form($id = NULL)
	{
		
		$method = 'get_new';

		if (intval($id) !== 0)
		$method = 'get';

		$this->data['program_options'] = $this->program_m->dropdown();
		$this->data['major'] = $this->major_m->$method($id);
		$this->data['formUrl'] = "major/confirm/{$id}";
		// to avoid invalid $id
		if (empty($this->data['major'])) 
		{
			$json['html'] = "<div class='alert alert-danger'>
								<strong>Invalid input. Access denied.</strong>
							</div>";
		}
		else
		{
			$json['html'] = $this->load->view('major/form', $this->data, TRUE);
		}
			
		return $this->output->set_content_type('application/json')->set_output(json_encode($json));

		// $this->data['formUrl'] = 'major/store/';

		// ! empty($majorId) && $this->data['formUrl'] .= '/' . $majorId;
		// $json['html'] = $this->load->view('major/form', $this->data, TRUE);
		// return $this->output->set_content_type('application/json')->set_output(json_encode($json));
	}
 	

 	public function confirm($id = NULL)
	{
		
		// $this->data['formUrl'] = 'major/store/';
		$this->data['formUrl'] = "major/store/{$id}";

		// $majorId = $this->input->post('majorId', TRUE);
		$this->data['program_options'] = $this->program_m->dropdown();

		$validation = $this->major_m->validation();
		// dump($majorId);

		if ($validation !== TRUE)
		{
			return self::form($id);
		}

		! empty($majorId) && $this->data['formUrl'] .= '/' . $id;
		$json['html'] = $this->load->view('major/confirm', $this->data, TRUE);
		return $this->output->set_content_type('application/json')->set_output(json_encode($json));
	}

	public function store($id = NULL) 
	{
		if ( ! $this->input->post())
		return FALSE;
		#$method = empty($id) ? 'get_new' : 'get';
		#$id = intval($id);
		#$college = $this->college_m->$method($id);
		// to avoid invalid $id
		#empty($college) && $college = $this->college_m->get_new();
		$rules = $this->major_m->rules;
		$this->form_validation->set_rules($rules);

		console.log($this->form_validation->run() == TRUE);

		if ($this->form_validation->run() == TRUE)
		{
			$post = $this->major_m->array_from_post(array_keys($rules));

			$id = $this->major_m->save($post, $id);

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

		return parent::redirect_with('major', $data);
	}


	public function _unique_code($value)
	{
		$id = $this->uri->segment(3);

		! empty($id) && $this->db->where('MajorId', $id);
		$major = $this->major_m->get_by(['MajorCode' => $value]);

		if ( ! empty($major))
		{
			$this->form_validation->set_message('_unique_code', 'The %s field is already exists.');
			return FALSE;
		}

		return TRUE;

	}
	
	public function _unique_name($value)
	{
		$id = $this->uri->segment(3);

		! empty($id) && $this->db->where('MajorId', $id);
		$major = $this->major_m->get_by(['MajorDesc' => $value]);

		if ( ! empty($major))
		{
			$this->form_validation->set_message('_unique_code', "The %s field is already exists.");
			return FALSE;
		}

		return TRUE;
	}

	// public function student_program()
	// {
		
	// }
	
	public function edit($id = NULL) 
	{
		if ($id == NULL) 
		{
			dump("Add New Major Page");
		}
		else
		{
			dump("Edit Major with id {$id} Page");
		}
	}

}

/* End of file Student_Evaluation.php */
/* Location: ./application/controllers/student_evaluation.php */