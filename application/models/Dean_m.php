<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dean_m extends MY_Model {

	protected $table_name = 'tbldean';
	protected $primary_key = "dean_id";
	protected $order_by = "college_id";

	protected $timestamps = FALSE;
	protected $soft_delete = FALSE;

	protected $protected_attribute = array(
		'is_actived', 'created_at', 'updated_at', 'deleted_at'
	);


	protected $controller = 'Dean';

	public function __construct()
	{
		parent::__construct();
		// $this->generate_sy();
	}

	public function dropdown($dean = FALSE)
	{
		$option = [];
		$dean = $this->get();

		if ($dean) 
		{
			foreach ($dean as $key => $row) {

				$name =  $row->Fname." ".$row->Mname." ". $row->Lname;
				$option[intval($row->college_id)]=array('dean_name' => $name,'Prefix'=>$row->Prefix,'Suffix'=>$row->Suffix);
			}
		}	
		else
		{
			foreach ($dean as $key => $row) {
				$name =  $row->Fname." ".$row->Mname." ". $row->Lname;

				$option[intval($row->college_id)]=$name;
			}
		}
		return $option;
	}

}

/* End of file Dean_m.php */
/* Location: ./application/models/Dean_m.php */