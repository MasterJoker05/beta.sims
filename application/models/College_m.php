<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class College_m extends MY_Model {

	protected $table_name = 'tblcollege';
	protected $primary_key = "CollegeId";
	protected $order_by = "CollegeDesc";

	protected $timestamps = FALSE;
	protected $soft_delete = FALSE;

	protected $protected_attribute = array(
		'is_actived', 'created_at', 'updated_at', 'deleted_at', 'CollegeId'
	);

	public $rules = array(
		'CollegeCode' => array('field' => 'CollegeCode', 'label' => 'College Code', 'rules' => 'trim|required|t|max_length[10]|callback__unique_code'),
        'CollegeDesc' => array('field' => 'CollegeDesc', 'label' => 'College Name', 'rules' => 'trim|required|t|max_length[255]|callback__unique_name'),
	);

	public $options = array(
	      						'CollegeCode' =>'College Code',
	      						'name' =>'College Name',
      						);

	protected $controller = 'college';

	public function __construct()
	{
		parent::__construct();
	}

	public function get_new()
	{
		$college = new stdClass();
		$college->CollegeCode = '';
		$college->CollegeDesc = '';

		return $college;
	}

	public function delete($id)
	{
		return false;
	}

	public function dropdown()
	{
		$option = [];
		$colleges = $this->get();

		foreach ($colleges as $key => $college) {
			$option[$college->CollegeId]=$college->CollegeDesc;
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
					$param1 = ["(CollegeDesc LIKE '%{$search}%')" => NULL];
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

/* End of file College_m.php */
/* Location: ./application/models/College_m.php */