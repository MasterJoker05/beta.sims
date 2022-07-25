<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leave_of_absence extends Admin_Controller {

	public $sysem, $SyId, $SemId;

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(['Curriculum_m','m_enroll','loa_m','sem_m','sy_m','dean_m']);
        $this->data['student_info_active'] = TRUE;
		$this->data['page_title'] = 'LEAVE OF ABSENCE';

		// $this->output->enable_profiler(TRUE);

	}

	public function index($StudNo)
	{

		$this->data['student_info'] = $this->Curriculum_m->get_student_profile($StudNo);

		$this->db->where('StudNo', $StudNo);
		$this->data['stud_loa'] = $this->loa_m->get();

		if ($this->input->post('btn_apply_loa') == 'apply_loa') {

			$post = $this->input->post();
			unset($post['btn_apply_loa']);
			$post['user_id'] = $this->session->userdata('Id'); 
			
			// dump($post);
			if ($post['LoaStartSemId'] == $post['LoaEndSemId']){
				$post['IsOneYear'] = 0;
				$post['IsOneSem'] = 1;
			}
			else{
				$post['IsOneYear'] = 1;
				$post['IsOneSem'] = 0;
			}


			$this->loa_m->save($post);
			$this->session->set_flashdata('success', 'Successfully Added');
			return redirect('leave_of_absence/'.$post["StudNo"],'refresh');
		}

		$sy_data = $this->sysem['SyId'];
		$this->db->where('SyId >=',$sy_data);
		$this->data['sy'] = $this->sy_m->dropdown();
		$this->data['sy_loa'] = $this->sy_m->dropdown(TRUE);
		$this->data['dean'] = $this->dean_m->dropdown(TRUE);
		$this->data['staff'] = $this->user_m->get_staff();
		$this->data['sem'] = $this->sem_m->dropdown();
		$this->data['print'] ='leave_of_absence/print_loa';
        $this->load_view('leave_of_absence/index');
	}

}

/* End of file Leave_of_absence.php */
/* Location: ./application/controllers/Leave_of_absence.php */




