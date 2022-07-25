<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

	public $data = array();

	function __construct()
	{
		parent::__construct();
		$this->data['errors'] = array();
		$this->data['site_name'] = config_item('site_name');
		
		$this->load->helper('form');
		$this->load->library('session');
		$this->data['student_info_active'] = FALSE;
		$this->sysem=$this->config->item('sy_sem');
		$this->SyId = $this->sysem['SyId'];
		$this->SyDesc = $this->sysem['SyDesc'];
		$this->SemId = $this->sysem['SemId'];
		$this->SemDesc = $this->sysem['SemDesc'];

		// if ($this->input->post('reset_button', TRUE) != NULL)
		// {
		// 	$this->_clear_search_results();
		// }

		// if ($this->session->userdata('page') != l($this->router->class))
		// {
		// 	dump($this->session->userdata);
		// 	dump($this->router->class);
		// 	exit();
		// 	$this->_clear_search_results();
		// }

	}

	public function _clear_search_results()
	{
		$this->session->unset_userdata('filter_result');
		$this->session->unset_userdata('filter_field');
		$this->session->set_userdata( 'page', l($this->router->class));
		// redirection here to make sure that session are totally cleared
		return redirect(l($this->router->class), 'refresh');
	}


	public function load_view($page)
	{
		$this->data['content'] = $page;
		$this->load->view('template', $this->data);
	}

	public function redirect_to($msg, $redirect_to = 'dashboard', $error = TRUE)
	{
		// $this->session->set_userdata($error == TRUE ? 'error' : 'success', $msg);
		if ($error == TRUE)
		{
			$this->session->set_flashdata('error', $msg);
		}
		else
		{
			$this->session->set_flashdata('success', $msg);
		}
		redirect(base_url($redirect_to));
	}

	public function redirect_with($uri, $data = array())
	{
		if (is_array($data))
		{
			foreach ($data as $key => $value)
			$this->session->set_flashdata($key, $value);
		}

		return redirect($uri);
	}

}

/* End of file Admin_Controller.php */
/* Location: ./application/controllers/site.php */
