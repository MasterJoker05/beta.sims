<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Withdraw_credentials extends Admin_Controller {

	public $sysem, $SyId, $SemId;

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(['Curriculum_m','m_enroll']);
        $this->data['student_info_active'] = TRUE;
		$this->sysem=$this->config->item('sy_sem');
		$this->SyId = $this->sysem['SyId'];
		$this->SemId = $this->sysem['SemId'];

	}

	public function index($StudNo)
	{
		$this->output->enable_profiler(TRUE);
		// $StudNo = $this->uri->segment(2);
		

		$this->data['student_info'] = $this->Curriculum_m->get_student_profile($StudNo);


		$this->data['page_title'] = 'WITHDRAW CREDENTIALS';
        $this->data['sysem'] = $this->sysem;
        $this->load_view('withdraw_credentials/index');
	}

}

/* End of file withdraw_credentials.php */
/* Location: ./application/controllers/withdraw_credentials.php */