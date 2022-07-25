<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sem_m extends MY_Model {

	protected $table_name = 'tblsem';
	protected $primary_key = "SemId";
	protected $order_by = "SemDesc";

	protected $timestamps = FALSE;
	protected $soft_delete = FALSE;

	protected $protected_attribute = array(
		'is_actived', 'created_at', 'updated_at', 'deleted_at'
	);


	protected $controller = 'Sem';

	public function __construct()
	{
		parent::__construct();
	}

	public function dropdown()
	{
		$option = [];
		$sem = $this->get();

		foreach ($sem as $key => $row) {
			$option[$row->SemId]=$row->SemDesc;
		}
		return $option;
	}

}

/* End of file Sem_m.php */
/* Location: ./application/models/Sem_m.php */