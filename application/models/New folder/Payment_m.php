<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_m extends CI_Model {

	public $variable;

	public $rules = [
	    		'gcash_no' => [
	    						'field' => 'gcash_no', 'label' => 'Your GCash Sim Number',
	    						'rules' => 'required|min_length[11]|max_length[11]',
	    					  ],
				'gcash_ref_no' => [
	    						'field' => 'gcash_ref_no', 'label' => 'GCash Reference No.',
	    						'rules' => 'required|max_length[45]|callback__unique[gcash_ref_no]',
	    					  ],
				'amount_you_pay' => [
	    						'field' => 'amount_you_pay', 'label' => 'Amount you pay thru GCash',
	    						'rules' => 'max_length[45]|callback__validate_amount',
	    					  ],
	    		'items[]' => [
	    						'field' => 'items[]', 'label' => '',
	    						'rules' => 'required',
	    					  ],
	    		'bill_amount' => [
	    						'field' => 'bill_amount', 'label' => '',
	    						'rules' => 'required|greater_than[0]',
	    					  ],
				'city_hall_amount' => [
	    						'field' => 'city_hall_amount', 'label' => '',
	    						'rules' => 'required',
	    					  ],
	    	];

	public function __construct()
	{
		parent::__construct();

	}

	/**
	 * $removeKeys
	 * $array(0 => array(), ...);
	 * $search_key_name
	 */
	public function remove_key($removeKeys, $array, $search_key_name = 'FeeId')
	{
		// loop through $array
		foreach ($array as $key => $row)
		{
			// test if the search key name exists in row array
			if (in_array($search_key_name, array_keys($row)))
			{
				if (is_array($removeKeys))
				{
					// we compare FeeId value in array $removeKeys
					if (in_array($row[$search_key_name], $removeKeys))
					{
						// then remove key
						unset($array[$key]);
					}
				}
				else
				{
					if ($row[$search_key_name] == $removeKeys)
					{
						unset($array[$key]);
					}
				}
			}
		}

		return $array;
	}

	public function extract_key($extractKeys, $array, $search_key_name = 'FeeId', $single = TRUE)
	{
		$data = [];
		// loop through $array
		foreach ($array as $key => $row)
		{
			// test if the search key name exists in row array
			if (in_array($search_key_name, array_keys($row)))
			{
				if (is_array($extractKeys))
				{
					// we compare FeeId value in array $extractKeys
					if (in_array($row[$search_key_name], $extractKeys))
					{
						if ($single == TRUE)
						{
							return $row;
						}

						// then add to data array
						$data[] = $row;
					}
				}
				else
				{
					if ($row[$search_key_name] == $extractKeys)
					{
						if ($single == TRUE)
						{
							return $row;
						}

						$data[] = $row;
					}
				}
			}
		}

		return $data;
	}

	public function get_olea_assessment($studno, $sy_id, $sem_id)
	{
		$this->load->model('M_assessment');

		$data['MiscFee'] = [];

		$assessment = $this->M_assessment->getStudentAssessment($studno, FALSE, $sem_id, $sy_id);
		$data['assessment_db_last'] = $this->db->last_query();
		// dump($assessment);

		if ($sem_id != 3)
		{
			// $this->db->where_not_in('C.FeeId', array(20, 21, 37, 51));
			// $data['MiscFee'] = $this->M_assessment->getStudentAssessment($studno);

			// $data['MiscFee'] = self::remove_key([20, 21, 37, 51], $assessment);
			$data['MiscFee'] = self::extract_key([FUND_TYPE_ORG, FUND_TYPE_LAB_FEE], $assessment, 'FundTypeId', FALSE);
		}

		// dump($miscfee);

		//get NTSP
		// $single = TRUE;
		// $this->db->where_in('C.FeeId', array(51));
		// $data['NstpFee'] = $this->M_assessment->getStudentAssessment($studno, $single);

		$data['NstpFee'] = self::extract_key(51, $assessment);

		//get Get Scholarship
		$data['Scholarship'] = $this->M_assessment->getScholarship($studno);
		// dump($this->db->last_query());

		//get Token Fee
		// $this->db->where_in('C.FeeId', array(20,21));
		// $data['TokenFee'] = $this->M_assessment->getStudentAssessment($studno, $single);
		$data['TokenFee'] = self::extract_key([20, 21], $assessment);
		// dump($data['TokenFee'], 'data[TokenFee]');
		if (empty($data['TokenFee'])) {
			$data['TokenFee']['Amount'] = 0;
		}

		//get ID FEE
		// $this->db->where_in('C.FeeId', array(37));
		// $data['IdFee']=$this->M_assessment->getStudentAssessment($studno, $single);
		$data['IdFee'] = []; // self::extract_key(37, $assessment);


		// parameter
		$where = [
			'SyId' 			=> $sy_id,
			'SemId' 		=> $sem_id,
			'student_id' 	=> $studno,
			'bill_is_closed != ' => 1,
			'bill_trans_date >'  => 0,
			'bill_type' 	=> 'ENROLLMENT',
			// 'bill_paid_amount >' => 0,
			// 'amount_due = amount_paid' => NULL,
			// 'C.FeeId IN (20, 21, 47) ' 	=> NULL,
		];
		$this->db->having('bill_paid_amount >', 0);
		//get Payment
		$payments 					= $this->M_assessment->sum_billing_payment_by($where);
		$data['db_last'] 			= $this->db->last_query();
		$data['all_payments'] 	    = $payments;

		if (empty($payments))
		{
			$where = [
				'StudNo' 	=> $studno,
				'SyId'		=> $sy_id,
				'SemId'		=> $sem_id,
				'A.FeeId IN (20, 21, 47)' => NULL,
			];
			$payments = $this->M_assessment->get_cash_payment_by($where);
		}

		// $data['TokenFeePayment']	= $this->M_assessment->get_tokenfee_payment($studno, $sy_id, $sem_id);
		$data['TokenFeePayment']	= self::extract_key([20, 21, 47], $payments);
		// dump($data['TokenFeePayment'], '--- TokenFeePayment ---');


		// $data['NstpPayment']		= $this->M_assessment->get_nstp_payment($studno, $sy_id, $sem_id);
		$data['NstpPayment']		= self::extract_key(51, $payments);

		// $data['MiscPayment']		= $this->M_assessment->get_miscfee_payment($studno, $sy_id, $sem_id);
		$data['MiscPayment']		= self::remove_key([20, 21, 37, 51], $payments);

		// $data['IdPayment']		= $this->M_assessment->get_id_payment($studno, $sy_id, $sem_id);
		$data['IdPayment']			= []; // self::extract_key(37, $payments);

		$data['scholarship'] 		= &$data['Scholarship'];

		empty($data['NstpFee']) && $data['NstpFee']['Amount'] = 0;
		empty($data['IdFee']) && $data['IdFee']['Amount'] = 0;

		$DiscountPercentage = 0;
		!empty($data['scholarship']) && $DiscountPercentage = $data['scholarship']['DiscountPercentage'];


		#$data['assess_trans'] 		= $assessment;

		$data['ID']		= 0;
		$data['NSTP']	= 0;
		$data['Misc'] 	= 0;

		$data['DiscountPercentage'] = $DiscountPercentage;


		$data['TokenFeePay'] 		= ! empty($data['TokenFeePayment']) ? $data['TokenFeePayment']['Amount'] : 0;


		if ($_SESSION['session']['student_curriculum']['IsTCP'] == 1 || $_SESSION['session']['student_curriculum']['IsGraduateProgram'] == 1) 
		{
			
			$data['TokenFeeAssessment'] = 0;


			$arr_criteria = [
				'StudNo' => $studno, 
				'SyId' => $sy_id, 
				'SemId' => $sem_id, 
				// 'assessed_by >' => 0, 
				'is_actived' => 1
			];

			$tuition_fee = $this->db->get_where('tblstudtuitions', $arr_criteria)->result();


			if ($tuition_fee) 
			{
				// Sum up Tuition fee & CMAT
				foreach ($tuition_fee as $tuition) 
				{
					
					$amount = $tuition->grand_total;
					$data['TokenFeeAssessment'] += $amount;

					$data['TuitionCMAT'][] = [
						'Description' => $tuition->cmat_id > 0 ? 'Change of Matriculation ' . ($tuition->grand_total > 0 ? 'Add' : 'Drop') : 'Tuition Fee',
						'Units' => $tuition->no_units,
						'Amount' => $amount,
					];

				}
			}
			
			$data['TokenFee']['FeeId'] = 47;
			$data['TokenFee']['Amount'] = $data['TokenFeeAssessment'];
			
			$assessment[] = [
				'FeeId' => $data['TokenFee']['FeeId'],
				'FeeDesc' => 'Tuition Fee',
				'Amount' => $data['TokenFee']['Amount'],
				'FundTypeId' => 1,
			];

		}
		else
		{

			$data['TokenFeeAssessment'] = get_num($data['TokenFee'], 'Amount');
			$data['TokenFee']['Amount'] = $data['TokenFee']['Amount'] - $data['TokenFeePay'] - ($data['TokenFee']['Amount'] * $DiscountPercentage);


			$data['Misc'] 	= getMiscFee($data['MiscPayment'], $data['MiscFee']);
			$data['NSTP']	= $data['NstpFee']['Amount'] - (!empty($data['NstpPayment']['Amount']) ? ($data['NstpPayment']['Amount']) : 0);
		}

		


		if ($data['TokenFee']['Amount'] == 0)
		{
			$assessment = self::remove_key([MKT_TOKEN_FEE_ID, NONMKT_TOKEN_FEE_ID, TUITION_FEE_ID], $assessment);
		}

		$paid_fees_arr = [ UNIVERSITY_ID ];

		if ($assessment)
		{
			$paid_fees = self::remove_key([MKT_TOKEN_FEE_ID, NONMKT_TOKEN_FEE_ID, TUITION_FEE_ID], $payments);
			if ($paid_fees)
			{
				foreach ($paid_fees as $fee)
				{

					$fee_id = get_key($fee, 'FeeId');
					$paid_fees_arr[] = $fee_id;

					if ($fee_id == NSTP_ID)
					{
						$data['NSTP'] = 0;
					}

				}
			}

		}


		$data['assess_trans'] = self::remove_key($paid_fees_arr, $assessment);
		$data['Partial'] = getPartialFee($data['TokenFee'],$data['Misc'],$data['NSTP'],$data['ID']);


		return $data;
	}

}

/* End of file Payment_m.php */
/* Location: ./application/models/Payment_m.php */