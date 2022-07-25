<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hd_m extends MY_Model {

	protected $table_name = 'tblstud_hd';
	protected $primary_key = "stud_hd_id";
	protected $order_by = "date_filed";

	protected $timestamps = FALSE;
	protected $soft_delete = TRUE;

	protected $protected_attribute = array(
		'is_actived', 'created_at', 'updated_at', 'deleted_at'
	);


	protected $controller = 'hd';

	public function __construct()
	{
		parent::__construct();
	}

}

/* End of file Hd_m.php */
/* Location: ./application/models/Hd_m.php */