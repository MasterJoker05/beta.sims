<?php
/**
* Filename: m_studassess.php
* Author: Brando Talaguit (ITC Developer)
* Date: 11/04/2015 07:20 PM
*/
class M_studassess extends MY_Model
{
	protected $table_name = "tblassessment";
	protected $primary_key = "reference_id";
	protected $primary_filter = "intval";
	protected $order_by = "reference_id";

	protected $protected_attribute = array();

	public $rules = array(
		'insert' => array(
			'enroll_id' => 	[
							'field' => 'enroll_id',
							'label' => '',
							'rules' => 'intval|required|is_natural_no_zero|callback__unique_enroll_not_closed' // callback__unique_enroll_not_closed|
						   	],
			'student_id' =>	[
							'field' => 'student_id',
							'label' => 'Student Id',
							'rules' => 'trim|t|required|max_length[10]|min_length[8]'
						   ],
			'student_name' =>	[
							'field' => 'student_name',
							'label' => 'Student Name',
							'rules' => 'trim|t|required|max_length[80]'
						   ],
			'assessment' =>	[
							'field' => 'assessment',
							'label' => 'Assessment',
							'rules' => 'trim|to_decimal'
						   ],
			'bill_amount' =>	[
							'field' => 'bill_amount',
							'label' => 'Bill Amount',
							'rules' => 'trim|to_decimal'
						   ],
		   'city_hall_amount' =>	[
							'field' => 'city_hall_amount',
							'label' => 'Token Fee',
							'rules' => 'trim|to_decimal|callback__validate_token_fee' // callback__validate_token_fee|
						   ],
			'nstp_amount' =>	[
							'field' => 'nstp_amount',
							'label' => 'NSTP Fee',
							'rules' => 'trim|to_decimal'
						   ],
			'misc_amount' =>	[
							'field' => 'misc_amount',
							'label' => 'Misc. Fee',
							'rules' => 'trim|to_decimal'
						   ],
		   'mode' =>	[
							'field' => 'mode',
							'label' => 'Mode of Payment',
							'rules' => 'intval'
						   ],
		)
	);

	function __construct()
	{
		parent::__construct();
	}

	public function generate_key($sy_id, $sem_id, $amount)
	{
		// $this->output->enable_profiler(TRUE);

    	$prefix = $sem_id . $sy_id;
    	$qry =  "ifnull(max(lpad(substr(umak_ref_id, 3, 5)+1, 5, '0')), '00001') as new_ref_id";
    	$this->db->like('umak_ref_id', $prefix, 'after');

    	$data = $this->db->select($qry, FALSE)->get('tblassessment')->row();

    	// Produces: A3160001
    	return $prefix . $data->new_ref_id . intval($amount);
	}

	public function update_assessmenttrans($StudNo,$SyId,$SemId,$Id)
	{
		$condition = array(
						'StudNo'  => $StudNo,
						'SyId'	  => $SyId,
						'SemId'   => $SemId,

					);

		$update = array('ReferenceId' => $Id);

		$this->db->where($condition);
		$this->db->update('tblassessmenttrans', $update);
	}


}

/*Location: ./application/models/m_studassess.php*/
