<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {

	public $system_maintenance = FALSE;

	public function __construct()
	{
		parent::__construct();
		$this->system_maintenance = FALSE;
        $this->load->model('user_m');
	}

	public function login()
	{
		// $this->output->enable_profiler(TRUE);
		// Redirect a user if he's already logged in
		$dashboard = 'dashboard';
		$this->user_m->logged_in() && redirect($dashboard);

		// Set form
		$rules = $this->user_m->rules;
		$this->form_validation->set_rules($rules);

		// Process form
		if ($this->form_validation->run() == TRUE)
		{
			if ($this->user_m->login() == FALSE)
			{
				$dashboard = 'site/login';
				$this->session->set_flashdata('error', '<li>Username or Password is incorrect.</li>');
			}
			// dump($this->session->userdata());
			// dump($this->user_m->logged_in());
			// exit();
			# authenticated and can now be redirected
			 return redirect($dashboard, 'refresh');
		}

		
		if (validation_errors())
		{
			$validation_msg = validation_errors('<li>','</li>');
			$this->session->set_flashdata('error', $validation_msg);
			redirect('site/login');
			// dump($validation_msg);
		}
		// Load view
		// $this->data['content'] = '';
		$this->data['system_maintenance'] = $this->system_maintenance;
		$this->data['form_url'] = form_open(NULL, ['class' =>'form-horizontal', 'role' => 'form']);
		$this->data['title'] = '<h2>User Login</h2>';

		return $this->load->view('new_login_form', $this->data);

	}

	public function logout()
	{
		$this->user_m->logout();
		return redirect('site/login');
	}

	public function hash($string)
	{
		return dump(hash('sha512', $string . ENCRYPT_KEY));
	}

	

}

/* End of file Site */
/* Location: ./application/controllers/Site */