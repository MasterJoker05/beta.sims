<?php 

class M_course extends MY_Model
{
	protected $table_name = "umakunil_integrated.tblstudcmat";
	protected $primary_key = "cmat_id";	
	protected $order_by = "";
	protected $SySem = NULL;
	protected $isactive = FALSE;
	
	public function __construct()
	{
		parent::__construct();

		// Array of Academic Year	
	}
}
?>