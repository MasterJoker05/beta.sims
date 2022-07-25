<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_barred extends MY_Model {

	protected $table_name = "tblbarredstudent";
	protected $primary_key = "stud_bar_id";
	protected $order_by = "StudNo";


	public function __construct()
	{
		parent::__construct();		
	}

}

/* End of file M_barred.php */
/* Location: ./application/models/M_barred.php */