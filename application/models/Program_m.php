<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Program_m extends MY_Model {

	protected $table_name = 'tblprogram';
	protected $primary_key = "ProgramId";
	protected $order_by = "ProgramDesc";

	protected $timestamps = FALSE;
	protected $soft_delete = FALSE;

	protected $protected_attribute = array(
		'is_actived', 'created_at', 'updated_at', 'deleted_at', 'ProgramId'
	);

	public $rules = array(

		'CollegeId' => array('field' => 'CollegeId', 'label' => 'College ID', 'rules' => 'trim|required|t|max_length[10]'),
		'ProgramCode' => array('field' => 'ProgramCode', 'label' => 'Program Code', 'rules' => 'trim|required|t|max_length[10]|callback__unique_code'),
		'ProgramDesc' => array('field' => 'ProgramDesc', 'label' => 'Program Description', 'rules' => 'trim|required|t|max_length[255]|callback__unique_name'),
	);

	public $options = array(
	      						'CollegeCode' =>'College Code',
	      						'ProgramCode' =>'Program Code',
	      						'name' =>'Program Name',
      						);

	protected $controller = 'program';

	public function __construct()
	{
		parent::__construct();
	}

	public function get_new()
	{
		$program = new stdClass();
		$program->CollegeId = '';
		$program->ProgramCode = '';
		$program->ProgramDesc = '';

		return $program;
	}

	public function delete($id)
	{
		return false;
	}

	public function dropdown()
	{
		$option = [];
		$programs = $this->get();

		foreach ($programs as $key => $program) {
			$option[$program->ProgramId]=$program->ProgramDesc;
		}
		return $option;
	}

	public function search($page = 0, $limit)
	{
		$search_arr = array();
		
		
		$rules = array(
			'by' => array('field' => 'by', 'label' => 'Search By',
							'rules' => 'trim'),
			'Search' => array('field' => 'Search', 'label' => 'Search Text',
							'rules' => 'trim|t'),
		);
		
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE)
		{

			$by = $this->input->post('by');
			$search = $this->input->post('Search');

			$search_field = array(
									'by' => $by,
									'search' => $search,
								);

			if ( $by && $search )
			{
				if ($by == 'name')
				{
					$param1 = ["(ProgramDesc LIKE '%{$search}%')" => NULL];
				}
				elseif (in_array($by, array_keys($this->data['options'])))
				{
					$param1 = [$by => "'$search'"];
				}
			}

			$param1 == FALSE || $search_arr = array_merge($search_arr, $param1);

			$this->session->set_userdata([
					'filter_result' => $search_arr,
					'filter_field' => $search_field,
					'page' => $this->controller,
				]);
			
			
		}
		else
		{
			if ($this->session->userdata('filter_result') != NULL)
			{
				$search_arr = $this->session->userdata('filter_result');
			}
		}

		return [];
		
	}

	public function validation($skip = FALSE)
	{
		if ($skip !== TRUE) {

			$this->form_validation->set_rules($this->rules);

			if ($this->form_validation->run() == FALSE)
			{
				return validation_errors();
			}
		}
		return TRUE;
	}

}

/* End of file Program_m.php */
/* Location: ./application/models/Program_m.php */