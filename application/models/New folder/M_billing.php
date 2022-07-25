<?php
/**
* Filename: m_billing.php
* Author: Brando Talaguit (ITC Developer)
* Date: 11/04/2015 07:20 PM
*/
class M_billing extends MY_Model
{
	protected $table_name 			= "tblbilling";
	protected $primary_key 			= "bill_id";
	protected $primary_filter 		= "intval";
	protected $order_by 			= "bill_id";

	protected $is_actived = "bill_is_active";

	protected $created_at = "bill_created_at";
	protected $updated_at = "bill_updated_at";
	protected $deleted_at = "bill_deleted_at";

	protected $show_in_active       = TRUE;

	protected $token_fee_ids 		= [MKT_TOKEN_FEE_ID, NONMKT_TOKEN_FEE_ID, TUITION_FEE_ID];
	protected $cmat_id  			= CMAT_ID;
	protected $nstp_id  			= NSTP_ID;
	protected $university_id  		= UNIVERSITY_ID;

	protected $feval = 'umakunil_feval.';
	// email settings
	public $email_subject = 'UMak Scan to pay: Proof of Payment';
	public $email_cc   = 'itc.scantopay@umak.edu.ph';
	public $email_to = 'accounting.scantopay@umak.edu.ph';
	public $email_from_alias = 'DO NOT REPLY - SCAN TO PAY';


	protected $protected_attribute = array(/*'amount_paid', */'bill_is_closed', 'bill_proof_payment', 'bill_post_date', /*'bill_paid_thru', 'bill_trans_date', */'bill_is_active');

	public $rules = array(
		'insert' => array(

			'sem_id' => 	[
							'field' => 'sem_id',
							'label' => '',
							'rules' => 'intval|required|is_natural_no_zero'
						   	],
			'acad_year' => 	[
							'field' => 'acad_year',
							'label' => '',
							'rules' => 'trim|required'
						   	],
			'student_id' =>	[
							'field' => 'student_id',
							'label' => 'Student Id',
							'rules' => 'trim|t|required|max_length[10]|min_length[8]'
						   ],
			'last_name' =>	[
							'field' => 'last_name',
							'label' => 'Lastname',
							'rules' => 'trim|t|required'
						   ],
			'first_name' =>	[
							'field' => 'first_name',
							'label' => 'Firstname',
							'rules' => 'trim|t|required'
						   ],
			'middle_name' =>[
							'field' => 'middle_name',
							'label' => 'Lastname',
							'rules' => 'trim|t'
						   ],
			'amount_due' =>	[
							'field' => 'amount_due',
							'label' => 'Amount Due',
							'rules' => 'trim|to_decimal'
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
    	$alphabet = ['A', 'B', 'C', 'D', 'E', 'G', 'F', 'H', 'I'];
    	$max = 9990;

    	// position sensitivity based on sy_id LENGTH
    	$char_position = 4;
    	$num_position = 5;

        if (strlen($sy_id) == 1)
        {
        	$char_position--;
	    	$num_position--;
        }

    	$arr_field = [
    					"max(substr(trim(umak_ref_id), {$char_position}, 1)) max_char",
					 ];

    	$qry = $this->db->select($arr_field, FALSE)
    				->like('umak_ref_id', $prefix, 'after')
    				->get($this->table_name)
    				->row();

    	if (in_array($qry->max_char, ['', '0', NULL]))
    	{
    		$char = 'A';
    		$num  = '0001';
    	}
    	else
    	{
    		# TO check if your using correct generation of series
        	# SELECT umak_ref_id, cast( substr(umak_ref_id, 4, 5) as UNSIGNED INT)
        	# FROM (`tblbilling`)
			# WHERE  `umak_ref_id`  LIKE '29A%'
			# order by umak_ref_id desc;

			$sql =  "lpad(max(cast( substr(umak_ref_id, {$num_position}, 5) as UNSIGNED INT))+1,4 ,'0') ref_id";
	    	$data = $this->db->select($sql, FALSE)
					 ->like('umak_ref_id', $prefix . $qry->max_char, 'after')
					 ->get('tblbilling')
					 ->row();

    		if ($data->ref_id > $max)
    		{
    			$key = array_search($qry->max_char, $alphabet);
    			$char = $alphabet[$key+1];

				$sql =  "ifnull(lpad(count(umak_ref_id)+1, 4, '0'), '0001') as new_ref_id";
		    	$data = $this->db->select($sql, FALSE)
						 ->like('umak_ref_id', $prefix . $char, 'after')
						 ->get('tblbilling')
						 ->row();

				$num = $data->new_ref_id;
    		}
    		else
    		{
	    		// $key  = array_search($qry->max_char, $alphabet);
	    		$char = $qry->max_char;
	    		$num  = $data->ref_id;
    		}

    	}

    	$transaction_no = $prefix . $char . $num ;

    	// Produces: 28A001101500
    	return $transaction_no;

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

	public function save_billing_details($post, $bill_id)
	{
		$details = array();
		$city_hall_amount = $this->input->post('city_hall_amount', TRUE);

		foreach ($post as $key => $value)
		{
			$data = array(
				'bill_detail_bill_id' 	=> $bill_id,
				'bill_detail_fee_id' 	=> $value['FeeId'],
				'bill_detail_amount' 	=> $value['Amount']
			);

			if (in_array($value['FeeId'], $this->token_fee_ids))
			{

				$data['bill_detail_amount'] = $city_hall_amount;

				if (empty($city_hall_amount))
				{
					$data = [];
				}
			}

			! empty($data) && $details[] = $data;
		}

		if (count($details))
		{
			$affected = $this->db->insert_batch('tblbilling_detail', $details);
		}
	}

	public function save_gcash_data($post, $id = NULL)
	{
		$gcash_data = array(
				[
					'bill_scan_ref_id'	  => $post['referece_number'],
					'bill_scan_bill_id'   => $post['bill_id'],
					'bill_scan_fieldname' => 'gcash_no',
					'bill_scan_value'	  => $post['gcash_no'],
					'bill_scan_status_id' => 1,
					'bill_scan_status' 	  => 'Good',
				],
				[
					'bill_scan_ref_id'	  => $post['referece_number'],
					'bill_scan_bill_id'   => $post['bill_id'],
					'bill_scan_fieldname' => 'gcash_ref_no',
					'bill_scan_value'	  => $post['gcash_ref_no'],
					'bill_scan_status_id' => 1,
					'bill_scan_status' 	  => 'Good',
				],
				[
					'bill_scan_ref_id'	  => $post['referece_number'],
					'bill_scan_bill_id'   => $post['bill_id'],
					'bill_scan_fieldname' => 'amount_you_pay',
					'bill_scan_value'	  => $post['amount_you_pay'],
					'bill_scan_status_id' => 1,
					'bill_scan_status' 	  => 'Good',
				],
			);

		if (count($gcash_data))
		$affected = $this->db->insert_batch('tblbill_scan2pay', $gcash_data);
	}

	public function save_transaction($bill_id = NULL)
	{
		$this->db->trans_start();


		/*$this->load->helper('date');
		$timestamp = now();
		$timezone = 'UP8';
		$date_t = date('Y-m-d H:i:s', gmt_to_local($timestamp, $timezone));*/
		$date_t = date('Y-m-d H:i:s');


		$student_id = $_SESSION['session']['student_info']['StudNo'];

		$sy_id  = $_SESSION['session']['sy_sem']['SyId'];
		$sem_id = $_SESSION['session']['sy_sem']['SemId'];



		$add_details     = TRUE;

		if ($bill_id)
		{

			$referece_number = $_POST['umak_ref_id'];

			$amount_you_pay = get_num($_POST, 'amount_you_pay');
			$total_payment  = to_decimal( $amount_you_pay + get_num($_POST, 'amount_paid') );


			# we add +10 TO amount due  -------------------------
			// $ibayad_fee_amount   = $_POST['bill_type'] == 'ENROLLMENT' ? IBAYAD_FEE_AMOUNT : 0;
			$ibayad_fee_amount   = 0;
			$_POST['amount_due'] = to_decimal( get_num($_POST, 'amount_due')+$ibayad_fee_amount );

			$bill_data = [
							'amount_paid'   => $total_payment,
							'amount_due'	=> $_POST['amount_due'],
							'bill_trans_date' => date('Y-m-d H:i:s'),
							'bill_paid_thru'=> 'iBayad Scan to Pay',
						 ];


			$add_details     = FALSE;
			$amount_paid_old = to_decimal($_POST['amount_paid']);

			$status 	= to_decimal($_POST['amount_due']) == $total_payment ? "Complete" : "Partial";
			$logs 		= "{$status} Payment FROM {$amount_paid_old} TO {$total_payment}";

			$action = array(
							[
								'student_id' 	=> $student_id,
								'action' 		=> $logs,
								'date_logged' 	=> $date_t
							],
							[
								'student_id' 	=> $student_id,
								'action' 		=> "UMak Ref No {$referece_number}",
								'date_logged' 	=> $date_t
							],
						);


			if ($ibayad_fee_amount)
			{
				// we Do NOT want to update these fields
				unset($bill_data['bill_trans_date']);
				unset($bill_data['bill_paid_thru']);

				$action[] = [
								'student_id' 	=> $student_id,
								'action' 		=> 'Add ' . $ibayad_fee_amount . ' to amount for ' . IBAYAD_FEE_NAME,
								'date_logged' 	=> $date_t,
							];

				$bill_items = array([
									'FeeId' 	=> IBAYAD_FEE_ID,
									'Amount' 	=> $ibayad_fee_amount,
								  ]);

			  	self::save_billing_details($bill_items, $bill_id);


			}


			# save logs
			$action && $this->db->insert_batch('tblenrollmentuserlogs', $action);
			# end logs ----------------------------------------

		}
		else
		{
			$referece_number = self::generate_key($sy_id, $sem_id, $_POST['bill_amount']);

			# we add billing information
			$bill_data = array(
							'bill_type' 	=> 'ENROLLMENT',
							'bill_trans_date' => date('Y-m-d H:i:s'),
							'umak_ref_id' 	=> $referece_number,
							'student_id' 	=> $student_id,
							'last_name' 	=> $_SESSION['session']['student_info']['Lname'],
							'first_name' 	=> $_SESSION['session']['student_info']['Fname'],
							'middle_name' 	=> $_SESSION['session']['student_info']['Mname'],
							'sem_id' 		=> $_SESSION['session']['sy_sem']['SemId'],
							'acad_year' 	=> $_SESSION['session']['sy_sem']['SyDesc'],
							'amount_due' 	=> to_decimal($_POST['bill_amount']),
							'amount_paid'   => to_decimal($_POST['amount_you_pay']),
							'bill_paid_thru'=> 'iBayad Scan to Pay',
						);

			$status = $_POST['bill_amount'] == $_POST['amount_you_pay'] ? "Complete" : "Partial";
			$action = array(
						[
							'student_id' => $student_id,
							'action' => "UMak Ref No {$referece_number} created",
							'date_logged' => $date_t
						],
						[
							'student_id' => $student_id,
							'action' => "Amount Due ". to_decimal($_POST['bill_amount']),
							'date_logged' => $date_t
						],
						[
							'student_id' => $student_id,
							'action' => "{$status} Payment of " . to_decimal($_POST['amount_you_pay']),
							'date_logged' => $date_t
						],
					);
			$this->db->insert_batch('tblenrollmentuserlogs', $action);
		}


		// billing and details
		$bill_id 		= self::save($bill_data, $bill_id);
		$add_details  &&  self::save_billing_details($_POST['items'], $bill_id);


		// we add warning message for short payment
		if ($bill_data['amount_paid'] < $bill_data['amount_due'])
		{
			$this->session->set_flashdata('error', 'The REQUIRED AMOUNT PAYABLE should be ' . nf($bill_data['amount_due'], 2) . ' to complete this transaction,
				Otherwise you will transact another one thru GCash with convenience fee.');
		}


		// gcash
		$gcash_data = array(
								'referece_number' => $referece_number,
								'bill_id' 		  => $bill_id,
								'gcash_no' 		  => $_POST['gcash_no'],
								'gcash_ref_no' 	  => $_POST['gcash_ref_no'],
								'amount_you_pay'  => $_POST['amount_you_pay'],
						  );

		$scan2pay 			= self::save_gcash_data($gcash_data);


		$this->db->trans_complete(); # Completing transaction
		/*Optional*/
		if ($this->db->trans_status() === FALSE)
		{
		    # Something went wrong.
		    $this->db->trans_rollback();
		    return FALSE;
		}
		else
		{
		    # Everything is Perfect.
		    # Committing data to the database.
		    $this->db->trans_commit();
		    return $referece_number;
		}
	}

	//get Payment with amount_paid not equal to amount_due
	public function bill_for_payment($studno, $single = TRUE)
	{
		// parameter
		$where = [
			'student_id' 			=> $studno,
			// 'acad_year'				=> $_SESSION['session']['sy_sem']['SyDesc'],
			// 'bill_trans_date > 0 ' 	=> NULL,
			'bill_is_closed != '	=> 1,
			'amount_due > ifnull(amount_paid, 0)' => NULL,
			'bill_created_at > ' => "2021-01-01 00:00:00",
		];
		$this->db->order_by('CAST(IF(bill_type="ENROLLMENT", 0, 1) as UNSIGNED), bill_trans_date');
		return parent::get_by($where, $single);
	}

	public function cmat_for_payment($studno)
	{
		$table = 'tblstudcmat';

		$arr_criteria = [
			'StudNo' => $studno,
			'SemId'  => $_SESSION['session']['sy_sem']['SemId'],
			'SyId'  => $_SESSION['session']['sy_sem']['SyId'],
			'approved_at > 0 ' => NULL,
			'confirm_at > 0 ' => NULL,
			'printed_at' => 0,
			'NULLIF(disapproved_note, "") IS NULL' => NULL,
		];

		$this->db->where($arr_criteria);

		return self::cmat(NULL);
	}

	public function cmat($id = NULL, $single = TRUE)
	{
		$method = intval($id) || $single ? 'row_array' : 'result_array';

		$id && $this->db->where('cmat_id', $id);
		$this->db->where('A.is_actived', 1);

		return $this->db->get('tblstudcmat as A')->$method();
	}

	public function sum_scan2payment($where)
	{
		$this->db->select('SUM(bill_scan_value) as Amount');
		$this->db->group_by('bill_scan_bill_id');
		return self::get_by_scan2pay($where);
	}

	public function get_scan2pay($id = NULL, $single = TRUE)
	{
		$method = intval($id) || $single ? 'row_array' : 'result_array';

		$id && $this->db->where('bill_scan_id', $id);
		$this->db->where('bill_scan_is_active', 1);

		return $this->db->get('tblbill_scan2pay as A')->$method();
	}

	public function get_by_scan2pay($where, $single = FALSE)
	{
		$this->db->where($where);
		return self::get_scan2pay(NULL, $single);
	}

	public function get_details($id)
	{
		$this->db->join('tblbilling_detail','bill_id = bill_detail_bill_id','left');
		$this->db->join('tblfees','FeeId = bill_detail_fee_id','left');
		$this->db->where('bill_id', $id);
		$bill = parent::get(NULL, FALSE);

		return $bill;
	}

	public function get_studtuition_cmat($cmat_id, $studno)
	{
		return $this->db->get_where('tblstudtuitions', ['cmat_id' => $cmat_id, 'is_actived' => 1, 'StudNo' => $studno])->row_array();
	}


	function payment_details($data = array())
	{
		$details['TokenFee'] = 0;
		$details['Id'] = 0;
		$details['Nstp'] = 0;
		$details['Misc'] = 0;
		$details['MiscFee'] = array();

		foreach ($data as $key => $val)
		{
			//get Token Fee
			if (in_array($val->bill_detail_fee_id, $this->token_fee_ids))
			  $details['TokenFee'] += $val->bill_detail_amount;
			elseif($val->bill_detail_fee_id == $this->university_id)
			  $details['Id'] += $val->bill_detail_amount;
			elseif($val->bill_detail_fee_id == $this->nstp_id)
			  $details['Nstp'] += $val->bill_detail_amount;
			else
			{
			  $details['Misc'] += $val->bill_detail_amount;
			  $details['MiscFee'][]=  array("FeeDesc" => $val->FeeDesc,"Amount" =>$val->bill_detail_amount);
			}
		}
		$details['Sum'] = array_sum($details);
		$details['bill_id'] = $data[0]->bill_id;
		$details['umak_ref_id'] = $data[0]->umak_ref_id;
		return $details;

	}

	public function send_email($message, $attached_file = NULL)
	{
		// to select email and to store email credential
		$this->db->where('sentcount < 490');
		$umak_email = $this->db->get($this->feval .'tblumakemailaccount')->row();
		$current_email = $umak_email->email;
		$current_pass = $umak_email->password;


		// email config
		$config = Array(
		    'protocol' => 'smtp',
		    'smtp_host' => 'ssl://smtp.googlemail.com',
		    'smtp_port' => 465,
		    'smtp_user' => $current_email,
		    'smtp_pass' => $current_pass,
		    'mailtype'  => 'html',
		    'charset'   => 'iso-8859-1'
		);

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		// Set to, from, message, etc.
		$this->email->from($current_email, $this->email_from_alias);
		$this->email->to($this->email_to);
		
		if ( ! empty($this->email_cc)) 
		$this->email->cc($this->email_cc);

		$this->email->subject($this->email_subject);

		$this->email->message($message);
		$this->email->attach($attached_file);

		$this->db->query('update ' .$this->feval. 'tblumakemailaccount set sentcount = sentcount+3 where umakemailaccount_id = '.$umak_email->umakemailaccount_id);

		return $result = $this->email->send();
		// echo $this->email->print_debugger();
	}


}

/*Location: ./application/models/m_billing.php*/
