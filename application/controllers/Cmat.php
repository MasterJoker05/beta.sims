<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cmat extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->library('user_agent');

		$this->load->model(['Cmat_m','Curriculum_m','m_enroll']);
		$this->data['page_title'] = "CHANGE OF MATRICULATION";
		$this->data['day'] = ['mon','tue','wed','thu','fri','sat','sun'];
		$this->data['day2'] = ['mon','tue','wed','thu','fri','sat','sun'];

		$this->output->enable_profiler(TRUE);
	}
	public function index()
	{
		

	}

	public function all()
	{

		// $SyId = $this->SyId;
		// $SemId = $this->SemId;

		$SyId = 11;
		$SemId = 2;

		$option = $this->input->post('options');
    	$search = $this->input->post('search');

    	echo $option;
    	echo $search;

    	if (!empty($option) && !empty($search)) {
	      $this->db->like($option, $search);
	    }

		$this->db->limit(25);
		
		$this->data['cmat'] = $this->Cmat_m->get_all($SyId ,$SemId);

		$this->data['page_title'] = "ALL TRANSACTION";
		$this->load_view('cmat/index');
	}

	public function awaiting_approval()
	{	

		// $SyId = $this->SyId;
		// $SemId = $this->SemId;

		$SyId = 11;
		$SemId = 2;

		$option = $this->input->post('options');
    	$search = $this->input->post('search');

    	echo $option;
    	echo $search;

    	if (!empty($option) && !empty($search)) {
	      $this->db->like($option, $search);
	    }

		$this->db->limit(5);
		
		$this->db->where('approved_at IS NULL');
		$this->db->where('printed_at = 0');
		$this->data['cmat'] = $this->Cmat_m->get_all($SyId ,$SemId);

		$this->data['page_title'] = "Awaiting Approval";
		$this->load_view('cmat/index');
	}

	public function approved()
	{

		// $SyId = $this->SyId;
		// $SemId = $this->SemId;

		$SyId = 11;
		$SemId = 2;
		
		$this->output->enable_profiler(TRUE);


		$option = $this->input->post('options');
    	$search = $this->input->post('search');

    	echo $option;
    	echo $search;

    	if (!empty($option) && !empty($search)) {
	      $this->db->like($option, $search);
	    }

		$this->db->limit(5);
		$this->db->where('approved_at > 0');
		$this->db->where('confirm_at != 0');
		$this->db->where('tblstudcmat.is_actived = 1');
		$this->data['cmat'] = $this->Cmat_m->get_approved($SyId ,$SemId);


		$this->data['page_title'] = "Approved Application";
		$this->load_view('cmat/index');
	}

	public function disapproved()
	{

		// $SyId = $this->SyId;
		// $SemId = $this->SemId;

		$SyId = 11;
		$SemId = 2;

		$this->output->enable_profiler(TRUE);


		$option = $this->input->post('options');
    	$search = $this->input->post('search');

    	echo $option;
    	echo $search;

    	if (!empty($option) && !empty($search)) {
	      $this->db->like($option, $search);
	    }

		$this->db->limit(5);
		$this->data['cmat'] = $this->Cmat_m->get_disapproved($SyId ,$SemId);


		$this->db->where("disapproved_note IS NOT NULL AND TRIM(disapproved_note) <> ''", NULL, FALSE);


		$this->data['page_title'] = "Disapproved Application";
		$this->load_view('cmat/index');
	}

	public function printed()
	{
		// $SyId = $this->SyId;
		// $SemId = $this->SemId;

		$SyId = 11;
		$SemId = 2;

		$this->output->enable_profiler(TRUE);


		$option = $this->input->post('options');
    	$search = $this->input->post('search');

    	echo $option;
    	echo $search;

    	if (!empty($option) && !empty($search)) {
	      $this->db->like($option, $search);
	    }

		$this->db->limit(5);
		$this->data['cmat'] = $this->Cmat_m->get_printed($SyId ,$SemId);

		$this->data['page_title'] = "Printed Application";
		$this->load_view('cmat/index');
	}



	public function view($cmat_id)
	{

		// $SyId = $this->SyId;
		// $SemId = $this->SemId;

		
		$SyId = 11;
		$SemId = 2;
		
		$this->output->enable_profiler(TRUE);


		$option = $this->input->post('options');
    	$search = $this->input->post('search');

    	echo $option;
    	echo $search;

    	if (!empty($option) && !empty($search)) {
	      $this->db->like($option, $search);
	    }

		$this->data['cmat'] = $this->Cmat_m->get_cmat_load($cmat_id ,$SyId ,$SemId);
		$this->data['cmat_final'] = $this->Cmat_m->get_cmat_final_load($cmat_id);
		

		$StudNo = $this->data['cmat'][0]->StudNo;

        $this->data['student_info_active'] = TRUE;
		$this->data['student_info'] = $this->Curriculum_m->get_student_profile($StudNo);

		$this->data['page_title'] = "Change of Matriculation Form";
		$this->load_view('cmat/show');
	}

}