<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Completion extends Admin_Controller {

	public $sysem, $SyId, $SemId;

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(['Curriculum_m','m_enroll', 'studgrade_m', 'completion_m']);
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

		$this->data['inc_grades'] = $this->studgrade_m->get_student_inc_grades($StudNo);
		$this->data['inc_grades_old'] = $this->completion_m->get_by(['inc_studno' => $StudNo]);



		$this->data['page_title'] = 'COMPLETION';
        $this->data['sysem'] = $this->sysem;
        $this->load_view('completion/index');
	}

	public function validate($id = NULL)
	{
		$this->input->is_ajax_request() || exit("No direct script access allowed");

		$rules = $this->completion_m->rules;
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == TRUE) 
		{

			$post = $this->completion_m->array_from_post(array_keys($rules));
			// $this->completion_m->save($post, $id);

			$this->session->set_flashdata('success', 'Success. Record successfully saved.');
			$json = ['status' => TRUE];
		}
		else
		{
			$json = [
						'status' => FALSE, 
						'errors' => $this->form_validation->error_array(),
						'validation_error' => validation_errors(), 
						'error_string' => $this->form_validation->error_string(),
					];
		}

		return $this->output->set_content_type('application/json')->set_output(json_encode($json));
		// echo json_encode($json);
		// dd($json);
		exit();
	}

	private function check_unique_number($id = NULL, $inc_receipt_no)
	{
		$this->db->where('inc_receipt_no', $inc_receipt_no);

		if ($id) {
			$this->db->where_not_in('completion_id', $id);
		}

		return $this->completion_m->count();
	}

	public function _check_receipt_no($inc_receipt_no)
	{
		if ($this->input->post('completion_id'))
			$id = $this->input->post('completion_id');
		else
			$id = NULL;

		$result = $this->check_unique_number($id, $inc_receipt_no);

		if ($result == 0) {
			$response = TRUE;
		} else {
			$this->form_validation->set_message('_check_receipt_no', 'This %s already exist');
			$response = FALSE;
		}

		return $response;
	}

	public function _valid_ay($str)
	{
        $current = date('Y');

        if ($str) 
        {
            $year = explode('-', $str);

            if (intval($str) > date('Y')) 
            {
                $this->form_validation->set_message('_valid_ay', "The %s is invalid.");
                return FALSE;
            }
            else if (strlen(trim($str)) != 9) 
            {
                $this->form_validation->set_message('_valid_ay', "The %s is not valid, size must be 9 characters only.");
                return FALSE;
            } 
            else if ($year[1] == $year[0]) 
            {
            	// can not be of the same year
            	$this->form_validation->set_message('_valid_ay', "The %s is not valid, can not be of the same year");
            	return FALSE;
            }
            else if ($year[1] - $year[0] > 1)
            {
            	$this->form_validation->set_message('_valid_ay', "Invalid format %s");
            	return FALSE;
            }
            else if ($year[1] < $year[0] || $year[1] > $current) 
            {
                $this->form_validation->set_message('_valid_ay', "Invalid format %s");
                return FALSE;
            }



        }

        return TRUE;
    }


}

/* End of file Student_curriculum.php */
/* Location: ./application/controllers/student_evaluation.php */