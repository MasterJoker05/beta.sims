<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends My_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('user_m');
		// $this->output->enable_profiler(TRUE);
		$this->data['page_title'] = "ACCOUNTS";
	}

	public function index()
	{	
		$this->load->library('pagination');

		$search_arr = array();
		$this->data['options'] = $this->user_m->options;

        $this->data['content'] = 'accounts/index';
        $this->data['college'] = $this->user_m->get_college();
        $this->data['curr'] = $this->user_m->get_curriculum();

        $this->data['users'] = $this->user_m->get();
		// create pagination links 
		$this->data['pagination'] = $this->pagination->create_links();

		$this->data['javascript'] = 'college/javascript';
		$this->data['search_arr'] = $this->session->userdata('filter_field');
		$this->data['search'] = get_key($this->data['search_arr'], 'search');
		$this->data['by'] = get_key($this->data['search_arr'], 'by', '');

        $this->load->view('template',$this->data);
	}

	public function save_account($id = NULL)
	{
		$result = array('Error'=>FALSE,'Msg'=>"");

		$post = $this->input->post();


		$rules = $this->user_m->rules_create_account;
		$this->form_validation->set_rules($rules);

		// Process form
		if ($this->form_validation->run() == TRUE)
		{
			//saving
			unset($post['repassword']);
			$post['user_passkey'] = $this->user_m->hash($post['user_passkey']);
			$post['user_department'] = implode(",", $post['user_department']);
			$post['user_curriculum_ids'] = implode(",", $post['user_curriculum_ids']);

			$this->user_m->save($post,$id);

			$this->session->set_flashdata('success', 'Added Account details have been saved');
			redirect('accounts','refresh');

		}
		else
		{
			//error
			$result['Error'] = TRUE;
			$result['Msg'] = validation_errors();

		}

		echo json_encode($result);
	}

	public function get_account_information()
	{
		$id = $this->input->post('id');

		$userInfo = $this->user_m->get($id,TRUE);
		
		echo json_encode($userInfo);

	}
}

/* End of file Accounts.php */