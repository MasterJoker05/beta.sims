<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loa_reason_m extends MY_Model {

	protected $table_name = 'tblstud_loa_reason';
	protected $primary_key = "ReasonId";
	protected $order_by = "reason";

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

	public function dropdown()
	{
		$option = [];
		$reasons = $this->get();
		foreach ($reasons as $key => $reason) {
			$option[$reason->ReasonId]=$reason->reason;
		}
			$option['OTHERS']='OTHERS';
		return $option;
	}

	
}

/* End of file Loa_reason_m.php */
/* Location: ./application/models/Loa_reason_m.php */