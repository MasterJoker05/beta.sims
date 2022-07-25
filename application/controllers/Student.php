<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends Admin_Controller {

	protected $token_fee_ids 		= [MKT_TOKEN_FEE_ID, NONMKT_TOKEN_FEE_ID, TUITION_FEE_ID];
	protected $cmat_id  			= CMAT_ID;
	protected $nstp_id  			= NSTP_ID;
	protected $university_id  		= UNIVERSITY_ID;
	protected $other_fee_ids  		= [NSTP_ID, UNIVERSITY_ID];
	protected $exclude_fee_ids 		= [UNIVERSITY_ID, PIA_ID, PIA2_ID];
	protected $scan2pay_fieldname   = ['gcash_no', 'gcash_ref_no', 'amount_you_pay'];

	public function __construct()
	{
		parent::__construct();

		$now = date('H:i:s');
		$today = date('N');

		$data['closing'] = FALSE;
		$data['open'] = FALSE;
		if ($now >= '14:45:00' && $today <= 5 && $today >= 1)
		{
			$data['closing'] = TRUE;
			$data['closing_message'] = "UMAK Scan to Pay is only available from Monday to Friday 6:00 A.M. to 3:00 P.M.";
		}

		if ($now <= '15:00:00' && $now >= '06:00:00' && $today <= 5 && $today >= 1)
		{
			$data['open'] = TRUE;
		}

		// if ($_SESSION['session']['student_info']['StudNo'] == 'A12032470')
		// $data['open'] = TRUE;

		if ($data['open'] == FALSE)
		{
			if (in_array($this->input->ip_address(), ['136.158.29.176', '130.105.202.200', '203.177.57.155', '111.125.91.131', '172.100.0.99']) || ENVIRONMENT == 'development')
			{
				$data['open'] = TRUE;
				$data['closing'] = FALSE;
			}
			else
			{
				$this->session->set_flashdata('error', 'UMAK Scan to Pay is only available from Monday to Friday 6:00 A.M. to 3:00 P.M.');
				redirect('site/logout');
			}

		}

		/*if (date("Y-m-d") > "2021-01-20")
		{
			$data['open'] = FALSE;
			$this->session->set_flashdata('error', 'UMAK Scan to Pay is now closed.');
		}*/

		//$data['open'] = FALSE;
		//$data['closing_message'] = "UMak SCAN TO PAY is now closed.";


		$data['session']	= $this->session->userdata('session');
		$data['student'] 	= $data['session']['student_info'];
		$data['curriculum'] = $data['session']['student_curriculum'];

		$data['student']['year_level']	= $data['session']['year_level'];
		$data['student']['email']		= $data['session']['email'];

		$data['token_fee_ids'] 		= [MKT_TOKEN_FEE_ID, NONMKT_TOKEN_FEE_ID];
		$data['cmat_id']  			= CMAT_ID;
		$data['nstp_id']  			= NSTP_ID;
		$data['university_id']  	= UNIVERSITY_ID;
		$data['other_fee_ids']  	= [NSTP_ID, UNIVERSITY_ID];

		$this->load->vars($data);

		$this->load->helper('file');
	}

	public function index()
	{
		$this->output->enable_profiler(TRUE);

		$this->load->model(['payment_m', 'm_billing', 'm_barred']);

		$student_id = $_SESSION['session']['student_info']['StudNo'];
		// dump($_SESSION['session']);
		$sy_id  = $_SESSION['session']['sy_sem']['SyId'];
		$sem_id = $_SESSION['session']['sy_sem']['SemId'];

		$this->db->select('Remarks', FALSE);
		$barred = $this->m_barred->get_by([
										   'StudNo' => $student_id, 
										   'cash' => 1,
										   '(is_reg_clear = 0 OR is_itc_clear = 0)' => NULL,
										]);

		if (count($barred))
		{
			$remarks = '';
			
			foreach ($barred as $bar)
			$remarks .= '<li>' . $bar->Remarks;

			$this->session->flashdata('error') && $remarks = '<li>' . $this->session->flashdata('error') . '</li>' . $remarks;			
			$this->session->set_flashdata('error', 'Hold please see below: <ul>'. $remarks . '</ul>');
		}


		// $bill_for_payment = [];

		$bill_for_payment = $this->m_billing->bill_for_payment($student_id, FALSE);
		if (count($bill_for_payment) == 0)
		{

			$olea_assessment = $this->payment_m->get_olea_assessment($student_id, $sy_id, $sem_id);
			// dump($olea_assessment, 'olea_assessment');

			$payment_tuition = (bool)$olea_assessment['TokenFeePayment'];
			$payment_misc    = (bool)$olea_assessment['MiscPayment'];
			$payment_nstp    = (bool)$olea_assessment['NstpPayment'];

			$GraduateFullScholar = FALSE;
			// scholarship
			if ($_SESSION['session']['student_curriculum']['IsTCP'] == 1 || $_SESSION['session']['student_curriculum']['IsGraduateProgram'] == 1)
			{
				if ($olea_assessment['scholarship'])
				{
					if ( get_num($olea_assessment, 'DiscountPercentage') == 1)
					{
						$GraduateFullScholar = TRUE;
					}
				}
			}

			// dump($payment_misc, 'payment_misc');
			// dump($payment_nstp, 'payment_nstp');
			// dump($payment_tuition, 'payment_tuition');
			// dump($GraduateFullScholar, 'GraduateFullScholar');

		}

		/*if ($payment_misc || $payment_nstp || $payment_tuition || $GraduateFullScholar)
		{
			// $cmat_for_payment = $this->m_billing->cmat_for_payment($student_id);
		}*/


		$this->data['javascript'] = 'student/javascript';

		if ($bill_for_payment)
		{
			// dump($bill_for_payment, 'bill_for_payment');
			// $ibayad_fee_amount = $bill_for_payment->bill_type == 'ENROLLMENT' ? IBAYAD_FEE_AMOUNT : 0;
			$ibayad_fee_amount = 0;

			$this->data['billing'] = $bill_for_payment;
			// $this->data['bill_amount'] = get_num($bill_for_payment, 'amount_due') - get_num($bill_for_payment, 'amount_paid') + $ibayad_fee_amount;
			$this->data['ibayad_fee_amount'] = $ibayad_fee_amount;

			$this->data['Misc'] 				= 0;
			$this->data['NSTP'] 				= 0;
			$this->data['ID'] 					= 0;

			$this->load_view('student/for_payment');
		}
		else
		{
			// dump('Regular 2nd sem payment');

			$this->data['MiscFee'] 		= $olea_assessment['MiscFee'];
			$this->data['NstpFee'] 		= $olea_assessment['NstpFee'];
			$this->data['Scholarship'] 	= $olea_assessment['Scholarship'];
			$this->data['TokenFee'] 	= $olea_assessment['TokenFee'];
			$this->data['IdFee'] 		= $olea_assessment['IdFee'];

			$this->data['TokenFeePayment'] 	= $olea_assessment['TokenFeePayment'];
			$this->data['NstpPayment'] 		= $olea_assessment['NstpPayment'];
			$this->data['MiscPayment'] 		= $olea_assessment['MiscPayment'];

			$this->data['IdPayment'] 	= $olea_assessment['IdPayment'];
			$this->data['scholarship'] 	= $olea_assessment['scholarship'];


			$this->data['assess_trans']    = remove_key($this->exclude_fee_ids, $olea_assessment['assess_trans']);

			$this->data['assess_trans'][]  = [
												'FeeDesc' => IBAYAD_FEE_NAME,
												'FeeId' => IBAYAD_FEE_ID,
												'Amount' => 10.00,
												'FundTypeId' => FUND_TYPE_IBAYAD
											 ];

			$this->data['other_fee_ass']   = remove_key($this->token_fee_ids,
												extract_key([FUND_TYPE_GEN, FUND_TYPE_IBAYAD], $this->data['assess_trans'], 'FundTypeId', FALSE)
											 );

			$this->data['DiscountPercentage'] 	= $olea_assessment['DiscountPercentage'];
			$this->data['TokenFeeAssessment'] 	= $olea_assessment['TokenFeeAssessment'];
			$this->data['TokenFeePay'] 			= $olea_assessment['TokenFeePay'];
			$this->data['Misc'] 				= $olea_assessment['Misc'];
			$this->data['NSTP'] 				= $olea_assessment['NSTP'];
			$this->data['ID'] 					= $olea_assessment['ID'];
			$this->data['Partial'] 				= $olea_assessment['Partial'];

			$this->data['hidden'] = ['student_id' => &$student_id];
			$this->load_view('student/index');
		}

	}

	public function show_qr()
	{
		$this->output->enable_profiler(FALSE);

		$this->input->is_ajax_request() || exit();

		$this->load->model(['m_billing', 'payment_m']);
		$this->load->library('table');
		$template = array(
		        'table_open'  => '<div class="table-responsive"><table class="table table-bordered table-sm table-dark table-striped">',
		        'table_close' => '</table></div>'
		);

		$this->table->set_template($template);


		$data  = [];

		$scan2payTitleHeader = ['Datetime', 'G-Cash No', 'Ref. Number', 'Amount'];
		$items = [
					['name' => 'Particulars', 'amount' => 'Amount']
				 ];

		
		$umak_ref_id  = $this->input->post('umak_ref_id', true);
		! empty($umak_ref_id) && $this->db->where('umak_ref_id', $umak_ref_id);

		$student_id = $_SESSION['session']['student_info']['StudNo'];
		$bill_for_payment = $this->m_billing->bill_for_payment($student_id);
		$token_fee = 0;

		$sy_id  = $_SESSION['session']['sy_sem']['SyId'];
		$sem_id = $_SESSION['session']['sy_sem']['SemId'];

		$olea_assessment = $this->payment_m->get_olea_assessment($student_id, $sy_id, $sem_id);
		$payment_tuition = (bool)$olea_assessment['TokenFeePayment'];
		$payment_misc    = (bool)$olea_assessment['MiscPayment'];
		$payment_nstp    = (bool)$olea_assessment['NstpPayment'];
		$data['olea_assessment'] = $olea_assessment;

		$GraduateFullScholar = FALSE;
		// scholarship
		if ($_SESSION['session']['student_curriculum']['IsTCP'] == 1 || $_SESSION['session']['student_curriculum']['IsGraduateProgram'] == 1)
		{
			if ($olea_assessment['scholarship'])
			{
				if ( get_num($olea_assessment, 'DiscountPercentage') == 1)
				{
					$GraduateFullScholar = TRUE;
				}
			}
		}

		// $bill_for_payment = [];

		/*if ($payment_misc || $payment_nstp || $payment_tuition || $GraduateFullScholar)
		{
			$bill_for_payment = $this->m_billing->bill_for_payment($student_id);
			// $cmat_for_payment = $this->m_billing->cmat_for_payment($student_id);
		}*/

		if ($bill_for_payment)
		{
			// $ibayad_fee_amount = $bill_for_payment->bill_type == 'ENROLLMENT' ? IBAYAD_FEE_AMOUNT : 0;
			$ibayad_fee_amount = 0;

			$bill_amount = get_num($bill_for_payment, 'amount_due') - get_num($bill_for_payment, 'amount_paid') + $ibayad_fee_amount;


			$obj_items   = $this->m_billing->get_details($bill_for_payment->bill_id);


			$post_obj    = [];
			foreach ($obj_items as $key => $value)
			{
				$post_obj[] = array(
					'FeeId' => get_key($value, 'FeeId'),
					'FundTypeId' => get_key($value, 'FundTypeId'),
					'FeeDesc' => get_key($value, 'FeeDesc'),
					'Amount' => get_num($value, 'bill_detail_amount'),
				);
			}


			$data['ibayad_fee_amount'] = $ibayad_fee_amount;
			$data['billing'] = $bill_for_payment;
			$post_items = $post_obj;

			$token_fee_ass 	= extract_key($this->token_fee_ids, $post_items);
			!empty($token_fee_ass) && $token_fee = $token_fee_ass['Amount'];

			$this->db->where_in('bill_scan_fieldname', $this->scan2pay_fieldname);
			$scan2pay = $this->m_billing->get_by_scan2pay(['bill_scan_bill_id' => $bill_for_payment->bill_id]);

			$scan2payTable = [];
			if ($scan2pay)
			{
				$row = [];
				$loop 		= 0;
				$mod_on_row = 3;
				foreach ($scan2pay as $key => $value)
				{
					$Datetime = date('M j, Y h:i A', strtotime($value['bill_scan_created_at']));
					$row = array_merge($row, [$value['bill_scan_value']]);
					$loop++;

					if ($loop % $mod_on_row == 0)
					{
						$scan2payTable[] = array_merge([$Datetime], $row);
						$row = [];
					}
				}

				$this->table->set_heading($scan2payTitleHeader);
				$data['scan2pay_table'] = $scan2payTable ? $this->table->generate($scan2payTable) : [];

			}



			if ($bill_for_payment->bill_type == 'CHANGE OF MATRICULATION')
			{

				$this->db->where_in('bill_scan_fieldname', 'cmat_id');
				$cmat = $this->m_billing->get_by_scan2pay(['bill_scan_bill_id' => $bill_for_payment->bill_id], TRUE);
				// dump($cmat, 'cmat');
				// dump($this->db->last_query());

				if ( ! $cmat)
				{
					echo "<div class='alert alert-info'>No items found for change of matriculation payment.</div>";
					echo '<button class="btn btn-link" type="button" id="btnPreviewCancelBtn" ><strong>Close this window</strong></button>';
					exit();
				}


				if ($_SESSION['session']['student_curriculum']['IsTCP'] == 1 || $_SESSION['session']['student_curriculum']['IsGraduateProgram'] == 1)
				{

					$cmat_id = $cmat['bill_scan_value'];
					$studtuition = $this->m_billing->get_studtuition_cmat($cmat_id, $student_id);

					// dump($studtuition, 'studtuition');
					// dump($this->db->last_query());
					if (intval($studtuition['assessed_by']) == 0)
					{
						echo "<div class='alert alert-info'>Your change of matriculation assessment is still waiting for the approval of the Accounting Office.</div>";
						echo '<button class="btn btn-link" type="button" id="btnPreviewCancelBtn" ><strong>Close this window</strong></button>';
						exit();
					}
				}
			}
		}
		else
		{
			$bill_amount = $this->input->post('bill_amount', TRUE);
			$token_fee 	 = $this->input->post('city_hall_amount', TRUE);
			$post_items  = $this->input->post('items', TRUE);
		}

		$token_fee_ass = 0;
		$misc_fee_ass  = 0;
		$nstp_fee_ass  = 0;

		if ($post_items)
		{
			$token_fee_ass 	= extract_key($this->token_fee_ids, $post_items);
			$misc_fee_ass  	= extract_key(FUND_TYPE_ORG, $post_items, 'FundTypeId', FALSE);
			$nstp_fee_ass  	= extract_key($this->nstp_id, $post_items);
			$other_fee_ass 	= remove_key($this->token_fee_ids, extract_key([FUND_TYPE_GEN, FUND_TYPE_IBAYAD], $post_items, 'FundTypeId', FALSE));
		}
		else
		{
			echo "No items found for payment.";
			echo '<button class="btn btn-link" type="button" id="btnPreviewCancelBtn" ><strong>Close this window</strong></button>';
			exit();
		}


		$total_misc_fee = 0.00;
		if ($misc_fee_ass)
		{
			foreach ($misc_fee_ass as $key => $fees)
			$total_misc_fee += get_num($fees, 'Amount');
		}

		$token_fee     &&  $token_fee_ass  &&  $items[] = ['name' => $token_fee_ass['FeeDesc'], 'amount' => nf($token_fee, 2)];
		$misc_fee_ass  && $items[] = ['name' => 'Miscellaneous Fee', 'amount' => nf($total_misc_fee, 2)];
		$nstp_fee_ass  && $items[] = ['name' => $nstp_fee_ass['FeeDesc'], 'amount' => nf(get_num($nstp_fee_ass, 'Amount'), 2)];

		if ( ! ($token_fee || $misc_fee_ass || $nstp_fee_ass))
		{
			$this->table->clear();
		}

		if ($other_fee_ass)
		{
			foreach ($other_fee_ass as $other_fee)
			{
				$items[] = ['name' => $other_fee['FeeDesc'], 'amount' => nf(get_num($other_fee, 'Amount'), 2)];
			}
		}

		$data['hidden'] = [
							'bill_amount' 		=> $bill_amount,
							'city_hall_amount'  => $token_fee,
							'items'				=> $post_items,
						  ];



		$data['payment_details_table'] = $this->table->generate($items);

		if ($bill_for_payment)
		{
			$data['hidden']['bill_id'] 	   = $bill_for_payment->bill_id;
			$data['hidden']['umak_ref_id'] = $bill_for_payment->umak_ref_id;
		}


		$this->load->view('modals/qrcode_scantopay', $data);
	}

	public function preview()
	{
		$this->input->is_ajax_request() || exit();

		$this->output->enable_profiler(FALSE);

		$this->load->model(['payment_m', 'm_billing']);
		
		// rules
		$rules = $this->payment_m->rules;
    	$this->form_validation->set_rules($rules);

    	// $_POST['proof_of_payment'] = file_get_contents($_FILES['proof_of_payment']['tmp_name']);
    	// dump($_FILES, 'files');
    	// $this->form_validation->set_data(['proof_of_payment' => file_get_contents($_FILES['proof_of_payment']['tmp_name'])]);
    	$this->form_validation->set_rules('proof_of_payment', 'Proof of Payment', 'trim|callback__is_image');


		$data['hidden'] = [
							'items' 			=> $this->input->post('items', TRUE),
							'bill_amount' 		=> $this->input->post('bill_amount', TRUE),
							'city_hall_amount' 	=> $this->input->post('city_hall_amount', TRUE),
							'gcash_no'			=> $this->input->post('gcash_no', TRUE),
							'gcash_ref_no'		=> $this->input->post('gcash_ref_no', TRUE),
							'amount_you_pay'	=> $this->input->post('amount_you_pay', TRUE),
						  ];

		$student_id = $_SESSION['session']['student_info']['StudNo'];
		$sy_id  = $_SESSION['session']['sy_sem']['SyId'];
		$sem_id = $_SESSION['session']['sy_sem']['SemId'];
		$olea_assessment = $this->payment_m->get_olea_assessment($student_id, $sy_id, $sem_id);
		$payment_tuition = (bool)$olea_assessment['TokenFeePayment'];
		$payment_misc    = (bool)$olea_assessment['MiscPayment'];
		$payment_nstp    = (bool)$olea_assessment['NstpPayment'];
		$data['olea_assessment'] = $olea_assessment;

    	if ($this->form_validation->run() == TRUE)
    	{


    		$umak_ref_id  = $this->input->post('umak_ref_id', true);
    		! empty($umak_ref_id) && $this->db->where('umak_ref_id', $umak_ref_id);

    		$student_id = $_SESSION['session']['student_info']['StudNo'];
    		$bill_for_payment = $this->m_billing->bill_for_payment($student_id);


	    	// ------ upload image -------------------------------- //

			//load file helper
			$this->load->helper('file');


			// get file parts of FILE proof of payment 
			$path_parts = pathinfo($_FILES["proof_of_payment"]["name"]);

			// generate new filename 
			$newfilename = $student_id . '-' . date('Ymd-H:i:s') . '-' . time() . '.' . $path_parts['extension'];

			// rename temp file to new filename
			// rename($_FILES["proof_of_payment"]["tmp_name"], '/tmp/' . $newfilename);

			// dump(DIRECTORY_SEPARATOR, 'directorySeparator');
			// dump(FCPATH, 'fcpath');
			// dump(FCPATH . 'assets/gcash' . DIRECTORY_SEPARATOR . $newfilename, 'newfilename');
			// would produce: /data/public_html/beta.scantopay/

			//Determine the path to which we want to save this file
			$newname = FCPATH . 'assets/gcash' . DIRECTORY_SEPARATOR . $newfilename;
			
			//Check if the file with the same name is already exists on the server
			if ( ! file_exists($newname)) 
			{
				$file_status = "Error: A problem occurred during file upload!";
				//Attempt to move the uploaded file to it's new place
				if ((move_uploaded_file($_FILES['proof_of_payment']['tmp_name'],$newname))) 
				{
					$file_status = "It's done! The file has been saved as: " . $newname;
				} 
			} 
			else 
			{
				$file_status = "Error: File " . $_FILES['proof_of_payment']['name'] ." already exists";
			}


			// WE email proof of payment images 
			// $email = $this->m_billing->send_email('Student Id: ' . $student_id . '<br>UMak Reference Id: ' . $umak_ref_id . '<br>This is a test image for scan to pay', $newname);


			$this->session->set_userdata( ['gcash_proof_of_payment' => $newname] );
			$data['gcash_proof_of_payment'] = $newfilename;

			// delete files from the server
			// unlink($newname); 


			// log payment status 
			$action = array([
								'student_id' => $student_id,
								'action' => $file_status,
								'date_logged' => date('Y-m-d H:i:s')
						]);
			$this->db->insert_batch('tblenrollmentuserlogs', $action);

			// dump(file_get_contents($_FILES['proof_of_payment']['tmp_name']), 'proof_of_payment');
			// ------------ end ------------------------------------------------- // 


    		$GraduateFullScholar = FALSE;
    		// scholarship
    		if ($_SESSION['session']['student_curriculum']['IsTCP'] == 1 || $_SESSION['session']['student_curriculum']['IsGraduateProgram'] == 1)
    		{
	    		if ($olea_assessment['scholarship'])
	    		{
	    			if ( get_num($olea_assessment, 'DiscountPercentage') == 1)
	    			{
	    				$GraduateFullScholar = TRUE;
	    			}
	    		}
    		}

    		// $bill_for_payment = [];

    		/*if ($payment_misc || $payment_nstp || $payment_tuition || $GraduateFullScholar)
    		{
    			$bill_for_payment = $this->m_billing->bill_for_payment($student_id);
    			// $cmat_for_payment = $this->m_billing->cmat_for_payment($student_id);
    		}*/


    		if ($bill_for_payment)
    		{
    			$data['hidden']['bill_id'] 	   = intval($bill_for_payment->bill_id);
    			$data['hidden']['umak_ref_id'] = $bill_for_payment->umak_ref_id;
    			$data['hidden']['amount_due']  = $bill_for_payment->amount_due;
    			$data['hidden']['amount_paid']  = $bill_for_payment->amount_paid;
    		}
    	}

    	$data['error'] = FALSE;
    	$data['error_array'] = FALSE;
    	if (validation_errors())
    	{
    		$data['error'] = validation_errors();
    		$data['error_array'] = $this->form_validation->error_array();
    	}


		$data['html'] = $this->load->view('modals/confirm_payment', $data, TRUE);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));

	}

	public function confirm_payment()
	{
		// $this->input->is_ajax_request() || exit();

		$this->agent->is_referral() && exit();

		$this->load->model(['m_studassess', 'm_billing', 'payment_m']);
		$this->output->enable_profiler(FALSE);

		// rules
    	$rules = $this->payment_m->rules;
    	$this->form_validation->set_rules($rules);

		// process form data
		if ($this->form_validation->run() == TRUE)
		{
			$student_id = $_SESSION['session']['student_info']['StudNo'];
			$billing = $this->m_billing->get_by(['umak_ref_id' => $this->input->post('umak_ref_id', TRUE), 'student_id' => $student_id], TRUE);

			$bill_id =  ! empty($billing) ? $billing->bill_id : NULL;
			$_POST['bill_type'] = $billing->bill_type;

			$transaction = $this->m_billing->save_transaction($bill_id);
			#$transaction = 'TEST ONLY';
			if ($transaction === FALSE)
			{
				$Msg = '<h4 class="alert alert-danger text-center"><b>Unable to tag student please try again.</b></h4>';
				$this->session->set_flashdata('error', $Msg);
			}
			else
			{
				//Determine the path to which we want to save this file
				$newname = $this->session->userdata('gcash_proof_of_payment');
				$umak_ref_id  = $this->input->post('umak_ref_id', TRUE);

				
				$this->load->helper('string');
				$random  = "<br><div style='display:none;'>" . date('Ymd-H-i-s') . random_string('alnum', 16) . "</div>";
				$content = 'Date: ' . date('F j, Y H:i:s') . '<br>Student Id: ' . $student_id . '<br>UMak Reference Id: ' . $umak_ref_id . '<br>Scan-to-Pay with Attached Proof of Screenshot' . $random;

				// WE email proof of payment images 
				$email = $this->m_billing->send_email($content, $newname);

				if ($this->session->userdata('gcash_proof_of_payment')) 
				{
					// delete files from the server
					unlink($this->session->userdata('gcash_proof_of_payment')); 
					$this->session->unset_userdata('gcash_proof_of_payment');
				}				

				// log GCash proof of payment email status 
				$action = array([
									'student_id' => $student_id,
									'action' => $email ? 'GCash proof of payment details email has been sent' : 'GCash proof of payment email FAILED TO SENT',
									'date_logged' => date('Y-m-d H:i:s')
							]);
				$this->db->insert_batch('tblenrollmentuserlogs', $action);

				$Msg  = '<h5 class="text-center"><b>Payment Transaction Successful!  <code><h1>UMak Reference Number ' . $transaction . '</h1></code></b></h5>';
				$Msg .= "<p>
						 	After successful transaction of payment for token fee  or  payment for Change of Matriculation (CMAT),  ITC will send the Official Certificate of Registration (COR)/Official Change of Matriculation to your UMak email account. This will take more or less two days once GCash payment is credited and verified.
						 </p>";


				$this->session->set_flashdata('success', $Msg);
			}
			// redirect('student');

		}

		$Msg = validation_errors();
		if ( ! empty($Msg))
		{
			$this->session->set_flashdata('error', $Msg);
		}
		else
		{

		}

		redirect('student');
	}

	public function _validate_amount()
	{
		$this->load->model('payment_m');

		$student_id = $_SESSION['session']['student_info']['StudNo'];
		$sy_id  = $_SESSION['session']['sy_sem']['SyId'];
		$sem_id = $_SESSION['session']['sy_sem']['SemId'];

		// post data
		$TokenToBePaid 	= to_decimal($this->input->post('city_hall_amount'));
		$amount_due		= to_decimal($this->input->post('bill_amount'));
		$amount_you_pay = to_decimal($this->input->post('amount_you_pay'));
		$umak_ref_id    = $this->input->post('umak_ref_id', TRUE);

		if ((bool)$amount_you_pay == FALSE)
		{
			$this->form_validation->set_message('_validate_amount', 'The GCash amount field is required');
			return FALSE;
		}

		if ($amount_you_pay <= 0)
		{
			$this->form_validation->set_message('_validate_amount', 'The GCash amount field can not have negative or zero value');
			return FALSE;
		}

		if ($umak_ref_id)
		{
			$bill_for_payment = $this->m_billing->bill_for_payment($student_id);

			if (empty($bill_for_payment))
			{
				$this->form_validation->set_message('_validate_amount', 'Reference number does not exists');
				return FALSE;
			}

			if ($amount_you_pay != $amount_due)
			{
				$this->form_validation->set_message('_validate_amount', '<b>Please Input Exact Amount </b>' . nf($amount_due,2));
				return FALSE;
			}
			return TRUE;
		}

		// fetch assessment
		$olea_assessment 	= $this->payment_m->get_olea_assessment($student_id, $sy_id, $sem_id);


		// assessment
		$TokenFee 		 	= $olea_assessment['TokenFeeAssessment'];

		// scholarship
		$scholarship 	 	= $olea_assessment['scholarship'];
		$DiscountPercentage = $olea_assessment['DiscountPercentage'];

		// payments
		$TokenFeePayment 	= $olea_assessment['TokenFeePay'];


		$TokenAssessment =  $TokenFee - ( ($TokenFee * $DiscountPercentage) + $TokenFeePayment);
		// produce 	1000 - ((1000 * 0.5) + 100)
		// result   1000 - ((500) + 100)
		// final    400

		// produce 	1000 - ((1000 * 0.5) + 0)
		// result   1000 - ((500) + 0)
		// final    500

		// produce 	1000 - ((1000 * 1) + 0)
		// result   1000 - ((1000) + 0)
		// final    0

		$Id 			= $olea_assessment['ID'];
		$Nstp 			= $olea_assessment['NSTP'];
		$Misc 			= $olea_assessment['Misc'];

		$OtherAmount 	= floatval($Id + $Misc + $Nstp);


		if ($DiscountPercentage != 1)
		{
			if ((bool)$TokenFeePayment == FALSE)
			{
				$TokenFee = $olea_assessment['TokenFee'];

				if ($TokenFee['FeeId'] == NONMKT_TOKEN_FEE_ID)
				{
					//for Non Makati
					if ($TokenToBePaid < 1000 && $TokenAssessment >= 1000)
					{
						$this->form_validation->set_message('_validate_amount', '<b>For Non-Makati Resident: Token Fee minimum amount is 1000</b>' );
						return FALSE;
					}
				}
				else
				{
					if ($TokenToBePaid < 500 && $TokenAssessment >= 500)
					{
						//for Makati
						$this->form_validation->set_message('_validate_amount', "<b>For Makati Resident: Token Fee minimum amount is 500</b>{$TokenToBePaid} assmt {$TokenAssessment}");
						return FALSE;
					}
				}
				/*if (($TokenToBePaid % 50) != 0)
				{
					//for Denomination
					$this->form_validation->set_message('_validate_amount', 'Invalid Amount Please Input Denomination of 50');
					return FALSE;
				}*/

				/*if (($TokenAssessment - $TokenToBePaid) < 100 && ($TokenAssessment - $TokenToBePaid) != 0)
				{
					$this->form_validation->set_message('_validate_amount', 'Cannot leave balance less than 100 Pesos');
					return FALSE;
				}*/
			}



		}

		// to catch exeeding payment or negative input
		if ((bool)$TokenFeePayment == FALSE)
		{
			if ($TokenToBePaid > $TokenAssessment || $TokenToBePaid < 0 )
			{
				//for Deanomination
				$this->form_validation->set_message('_validate_amount', 'Invalid Amount! please input Amount within your Token Fee');
				return FALSE;
			}
		}

		if ($amount_you_pay > $amount_due)
		{
			$this->form_validation->set_message('_validate_amount', 'Invalid Amount! please input '. nf($amount_due, 2));
			return FALSE;
		}

		return TRUE;
	}

	public function _unique($str, $field)
	{
		$table = 'tblbill_scan2pay';
		$gcash = $this->db
					->where([
						'bill_scan_fieldname' => $field,
						'bill_scan_value' => $str,
						'bill_scan_is_active' => 1,
					])->get($table);

		if ($gcash->num_rows() > 0)
		{
			$this->form_validation->set_message('_unique', 'The GCash reference number you entered is already been used.');
			return FALSE;
		}

		$gcash_no		= $this->input->post('gcash_no', TRUE);
		$gcash_ref_no	= $this->input->post('gcash_ref_no', TRUE);

		if (strlen($gcash_no) > 0 && strlen($gcash_ref_no) > 0 && $gcash_no == $gcash_ref_no)
		{
			$this->form_validation->set_message('_unique', 'The GCash reference number and GCash Number are having same entry, Please verify your entry.');
			return FALSE;
		}

		return TRUE;
	}

	public function history()
	{
		$this->output->enable_profiler(FALSE);
		$this->input->is_ajax_request() || exit();

		$this->load->model(['m_billing']);
		$this->load->library('table');
		$template = array(
		        'table_open'  => '<div class="table-responsive"><table class="table table-bordered table-sm table-striped">',
		        'table_close' => '</table></div>'
		);

		$this->table->set_template($template);

		$studno = $_SESSION['session']['student_info']['StudNo'];
		$ibayad_fee_id = IBAYAD_FEE_ID;

		$where = [
			'student_id' 			=> $studno,
			'bill_trans_date > 0 ' 	=> NULL,
			'bill_is_closed != '	=> 1,
			'amount_due = ifnull(amount_paid, 0)' => NULL,
			'acad_year >= '			=> '2020-2021',
		];

		$fields = [
			'bill_trans_date',
			'CONCAT(SemCode, " A.Y. ", acad_year) as sem_acad_year',
			'amount_due',
			"(SELECT SUM(bill_detail_amount) FROM tblbilling_detail
				WHERE bill_id = bill_detail_bill_id
					AND bill_detail_fee_id != {$ibayad_fee_id}
			) as total_amount" => NULL,

		];

		$this->db
				->select($fields)
				->join('tblsem', 'SemId = sem_id', 'left')
				->order_by('bill_trans_date Desc');

		$billing = $this->m_billing->get_by($where);

		$history = [ ['Datetime', 'Semester/Academic Year', 'Amount'] ];

		foreach ($billing as $payment)
		{
			$history[] = [
				date('M d, Y h:i:s a', strtotime($payment->bill_trans_date)),
				$payment->sem_acad_year,
				nf($payment->amount_due, 2)
			];
		}
		echo "<h4>History of Transaction</h4>";
		echo $this->table->generate($history);
		echo '<button class="btn btn-link" type="button" data-dismiss="modal" aria-hidden="true" ><strong>Close this window</strong></button>';
	}

	/*
	* file value and type check during validation
	*/
	public function _is_image($str) 
	{

		if ( ! empty($_FILES['proof_of_payment']) && ($_FILES['proof_of_payment']['error'] == 0) )
		{
			$allowed_mime_type_arr = array(
					/*'application/pdf',*/
					'image/gif',
					'image/jpeg',
					'image/pjpeg',
					'image/png',
					'image/x-png'
				);

			$mime = get_mime_by_extension($_FILES['proof_of_payment']['name']);

			if (in_array($mime, $allowed_mime_type_arr)) 
			{
				if ($_FILES['proof_of_payment']['size'] > 4000000)
				{
					$this->form_validation->set_message('_is_image', 'File exceeds maximum size (4MB). Only images under 4 MB are accepted for upload.');
					return FALSE;
				}
				else
				{
					return TRUE;
				}
			} 
			else 
			{
				$this->form_validation->set_message('_is_image', 'Please select only pdf/gif/jpg/png file.');
				return false;
			}

		}
		else
		{
			$this->form_validation->set_message('_is_image', 'No file uploaded. Please choose a file to upload.');
			return false;
		}

	}

}

/* End of file Student 5.php */
/* Location: ./application/controllers/Student 5.php */