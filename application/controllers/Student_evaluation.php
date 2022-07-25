<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student_Evaluation extends Admin_Controller {

	public $sysem,$SyId,$SemId;

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(['Curriculum_m','m_enroll']);
	}

	public function index($CollegeCode)
	{
		$this->output->enable_profiler(TRUE);
		// $CollegeCode = 'CCIS';
		// $CollegeCode = $this->uri->segment(2);
		$this->data['curriculum_list'] = $this->Curriculum_m->get_active_curriculum($this->SyId,$this->SemId,$CollegeCode);
		$this->data['page_title'] = 'STUDENT EVALUATION';
		$this->data['CollegeCode'] = $CollegeCode;


        // dump($this->data['sysem']);
        // exit();
        $this->load_view('student_evaluation/index');
	}

	public function student_program()
	{
		$CollegeCode = $this->uri->segment(3);
		$CurrId = $this->uri->segment(4);

		$this->data['curriculum_list'] = $this->Curriculum_m->get_active_curriculum($this->SyId,$this->SemId,$CollegeCode);

		$this->data['student_list'] = $this->Curriculum_m->get_active_per_curriculum($this->SyId,$this->SemId,$CollegeCode,$CurrId);

		$this->data['CollegeCode'] = $CollegeCode;
		$this->data['page_title'] = 'STUDENT EVALUATION';

        $this->load_view('student_evaluation/student_program');
	}

	public function student()
	{
		$student_id = $this->uri->segment(3);
		// $this->data['curriculum_list'] = $this->Curriculum_m->get_active_curriculum($SyId,$SemId,$CollegeCode);

		$this->data['student_info_active'] = TRUE;
		$this->data['student_info'] = $this->Curriculum_m->get_student_profile($student_id);

		$single = FALSE;
		$return_type = 'array';

		$enroll_trans = $this->Curriculum_m->get_enroll_trans(
				$student_id, 
				$single, 
				$return_type 
			);

		$this->data['enrollment_trans'] = $this->Curriculum_m->table_generate($enroll_trans, [
				'Semester',
				'Academic Year',
				'Is Encoded',
				'Official COR',
				'Status',
			]);

		// $this->data['student_info'] = $this->Curriculum_m->get_active_student($this->SyId,$this->SemId,$StudNo);

		$this->data['page_title'] = 'STUDENT PROFILE';
        $this->data['sysem'] = $this->sysem;

        $this->load_view('student_evaluation/student');
	}

}

/* End of file Student_Evaluation.php */
/* Location: ./application/controllers/student_evaluation.php */