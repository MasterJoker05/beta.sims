<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Major_m extends MY_Model {

	protected $table_name = 'tblmajor';
	protected $primary_key = "MajorId";
	protected $order_by = "MajorDesc";

	protected $timestamps = FALSE;
	protected $soft_delete = FALSE;

	protected $protected_attribute = array(
		'is_actived', 'created_at', 'updated_at', 'deleted_at'
	);

	public $rules = array(
		'ProgramId' => array('field' => 'ProgramId', 'label' => 'Program ID', 'rules' => 'trim|required|t|max_length[10]'),
		'MajorCode' => array('field' => 'MajorCode', 'label' => 'Major Code', 'rules' => 'trim|required|t|max_length[10]|callback__unique_code'),
		'MajorDesc' => array('field' => 'MajorDesc', 'label' => 'Description', 'rules' => 'trim|required|t|max_length[255]|callback__unique_name'),
	);

	public $options = array(
	      						'ProgramCode' =>'Program Code',
	      						'ProgramDesc' =>'Program Description',
	      						'MajorCode' =>'Major Code',
	      						'name' =>'Major Description',
      						);

	protected $controller = 'major';

	public function __construct()
	{
		parent::__construct();
	}

	public function get_new()
	{
		$major = new stdClass();
		$major->MajorCode = '';
		$major->MajorDesc = '';

		return $major;
	}

	public function delete($id)
	{
		return false;
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
					$param1 = ["(MajorDesc LIKE '%{$search}%')" => NULL];
				}
				elseif ($by == 'ProgramDesc')
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

/* End of file Major_m.php */
/* Location: ./application/models/Major_m.php */