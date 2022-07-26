<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permanent_record extends Admin_Controller {

	public $sysem,$SyId,$SemId;

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(['Curriculum_m','m_enroll','Studgrade_m']);

        $this->data['student_info_active'] = FALSE;

		$this->sysem = $this->config->item('sy_sem');
		$this->SyId  = $this->sysem['SyId'];
		$this->SemId = $this->sysem['SemId'];
		$this->data['page_title'] = 'STUDENT PERMANENT RECORD';

		// $this->output->enable_profiler(TRUE);
	}


	public function index($student_id)
	{
		$studentGrades = $this->Studgrade_m->get_student_grades($student_id);

		$this->data['student_info_active'] = TRUE;
		$this->data['student_info'] = $this->Curriculum_m->get_student_profile($student_id);
		$this->data['student_grades'] = permanentRecord($studentGrades) ;

        $this->load_view('permanent_record/index');
	}

	public function print_all($student_id)
	{
		$studentGrades = $this->Studgrade_m->get_student_grades($student_id);
		
		$this->data['student_info_active'] = TRUE;
		$this->data['student_info'] = $this->Curriculum_m->get_student_profile($student_id);
		$this->data['student_grades'] = permanentRecordPrint($studentGrades) ;

		$this->load->view('permanent_record/print_permanent_record', $this->data);
	}

}

/* End of file permanent_record.php */
/* Location: ./application/controllers/permanent_record.php */