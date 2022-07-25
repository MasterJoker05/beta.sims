<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sy_m extends MY_Model {

	protected $table_name = 'tblsy';
	protected $primary_key = "SyId";
	protected $order_by = "SyDesc";

	protected $timestamps = FALSE;
	protected $soft_delete = FALSE;

	protected $protected_attribute = array(
		'is_actived', 'created_at', 'updated_at', 'deleted_at'
	);


	protected $controller = 'Sy';

	public function __construct()
	{
		parent::__construct();
		// $this->generate_sy();
	}

	public function dropdown($loa = FALSE)
	{
		$option = [];
		$sy = $this->get();

		if ($loa) 
		{
			foreach ($sy as $key => $row) {
				$option[$row->SyId]=array('Code' => $row->SyCode,'Desc'=>$row->SyDesc);
			}
		}	
		else
		{
			foreach ($sy as $key => $row) {
				$option[$row->SyId]=$row->SyDesc;
			}
		}
		return $option;
	}

}

/* End of file Sy_m.php */
/* Location: ./application/models/Sy_m.php */