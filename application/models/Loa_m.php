<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loa_m extends MY_Model {

	protected $table_name = 'tblstud_loa';
	protected $primary_key = "stud_loa_id";
	protected $order_by = "date_filed";

	protected $timestamps = FALSE;
	protected $soft_delete = TRUE;

	protected $protected_attribute = array(
		'is_actived', 'created_at', 'updated_at', 'deleted_at'
	);


	protected $controller = 'leave_of_absence';

	public function __construct()
	{
		parent::__construct();
	}

	

	
}

/* End of file Loa_m.php */
/* Location: ./application/models/Loa_m.php */