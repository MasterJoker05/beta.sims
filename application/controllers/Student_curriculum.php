<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student_Curriculum extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(['Curriculum_m','m_enroll']);
		$this->data['student_info_active'] = TRUE;
		$this->sysem=$this->config->item('sy_sem');
			$this->SyId = $this->sysem['SyId'];
		$this->SyDesc = $this->sysem['SyDesc'];
		$this->SemId = $this->sysem['SemId'];
		$this->SemDesc = $this->sysem['SemDesc'];
	}

	// public function index()
	// {
	// 	$CollegeCode = $this->uri->segment(2);
	// 	$sysem=$this->session->userdata('sysem');
	// 	$SyId = $sysem->SyId;
	// 	$SemId = $sysem->SemId;
	// 	$this->data['curriculum_list'] = $this->Curriculum_m->get_active_curriculum($SyId,$SemId,$CollegeCode);

	// 	$this->data['page_title'] = 'STUDENT CURRICULUM';

 //        $this->data['sysem'] = $sysem;
 //        $this->data['content'] = 'Student_curriculum/index';
 //        $this->load->view('template',$this->data);
	// }

	// public function student_program()
	// {
	// 	$CollegeCode = $this->uri->segment(3);
	// 	$CurrId = $this->uri->segment(4);
	// 	$sysem=$this->session->userdata('sysem');
	// 	$SyId = $sysem->SyId;
	// 	$SemId = $sysem->SemId;
	// 	$this->data['curriculum_list'] = $this->Curriculum_m->get_active_curriculum($SyId,$SemId,$CollegeCode);

	// 	$this->data['student_list'] = $this->Curriculum_m->get_active_per_curriculum($SyId,$SemId,$CollegeCode,$CurrId);

	// 	$this->data['page_title'] = 'STUDENT EVALUATION';
 //        $this->data['sysem'] = $sysem;

 //        $this->data['content'] = 'Student_curriculum/student_program';
 //        $this->load->view('template',$this->data);
	// }

	public function student($StudNo)
	{
		$this->data['student_info'] = $this->Curriculum_m->get_student_profile($StudNo);


		

		$this->data['page_title'] = 'STUDENT CURRICULUM';
        $this->data['sysem'] = $this->sysem;
        $this->load_view('Student_curriculum/index');

	}

}

/* End of file Student_curriculum.php */
/* Location: ./application/controllers/student_evaluation.php */