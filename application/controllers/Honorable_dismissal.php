<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Honorable_dismissal extends Admin_Controller {

	public $sysem, $SyId, $SemId;

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(['Curriculum_m','m_enroll','hd_m']);
        $this->data['student_info_active'] = TRUE;
		$this->data['page_title'] = 'HONORABLE DISMISSAL';


	}

	public function index($StudNo)
	{
		$this->output->enable_profiler(TRUE);
		

		$this->data['student_info'] = $this->Curriculum_m->get_student_profile($StudNo);


		$this->db->where('StudNo', $StudNo);
		$this->data['stud_hd'] = $this->hd_m->get();

		

        $this->data['sysem'] = $this->sysem;
        $this->load_view('honorable_dismissal/index');
	}

}

/* End of file Honorable_dismissal.php */
/* Location: ./application/controllers/Honorable_dismissal.php */