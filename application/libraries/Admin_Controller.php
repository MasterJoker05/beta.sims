<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends MY_Controller
{
	protected $limit = 15;

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');

		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('user_agent');

		$this->form_validation->set_error_delimiters('<li>', '</li>');

		$this->load->model('User_m', 'user_m');
		$this->load->model('M_enroll', 'm_enroll');

		// Login Check
		$exception_uris = array(
			'login',
			'site',
			'site/index',
			'logout',
			'student/logout'
		);

		if (in_array(uri_string(), $exception_uris) == FALSE)
		{
			if ($this->user_m->logged_in() == FALSE)
			{
				return redirect('login');
			}
		}

		$attribute = ['role' => 'form', 'class' => 'form-horizontal'];
		$this->data['form_url'] = form_open(NULL, $attribute);
		$this->data['audit_trail'] = 'audit_trail';
		$this->data['counter'] = $this->uri->segment(3, 0);

		$this->data['error'] 	= FALSE;
		$this->data['success'] 	= FALSE;
		$this->data['info'] 	= FALSE;
		$this->data['warning'] 	= FALSE;
		$this->data['message'] 	= '';
		$this->data['redirect']	= '/';

		$session = $this->session->all_userdata();
		
		if ($this->user_m->logged_in() == TRUE) 
		{
			$this->data['user_session'] = [
				'logged_in'  => $session['logged_in'],
			];
		}
	}

	public function _error($message = 'Access is not allowed.')
	{
		$this->data['error'] = TRUE;
		$this->data['message'] = "<div class='alert alert-danger'>\nError.<br>\n{$message}\n</div>";
		return $this->data;
	}

	public function _success($message = 'Success.')
	{
		$this->data['success'] = TRUE;
		$this->data['message'] = "<div class='alert alert-success'>\nSuccess.\n{$message}\n</div>";
		return $this->data;
	}

	public function redirectWithError($url, $message)
	{
		$this->_error($message);
		return redirect($url,'refresh');
	}

}

/* End of file Admin_Controller.php */
/* Location: ./application/controllers/Admin_Controller.php */