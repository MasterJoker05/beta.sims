<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student_information_m extends MY_Model {

	protected $table_name = 'tblstudinfo';
	protected $primary_key = "StudNo";
	protected $order_by = "";

	protected $timestamps = FALSE;
	protected $soft_delete = FALSE;

	protected $protected_attribute = array(
		'is_actived', 'created_at', 'updated_at', 'deleted_at'
	);

	public $rules = array(
		'Fname' => array('field' => 'Fname', 'label' => 'Firstname', 'rules' => 'trim|required|t|max_length[10]'),
        'Lname' => array('field' => 'Lname', 'label' => 'Lastname', 'rules' => 'trim|required|t|max_length[255]'),
        'Mname' => array('field' => 'Mname', 'label' => 'Middlename', 'rules' => 'trim|required|t|max_length[255]'),
	);

	public function __construct()
	{
		parent::__construct();
	}


}