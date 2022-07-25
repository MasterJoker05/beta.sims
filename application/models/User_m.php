<?php
/**
* Filename: user_m.php
* Author: Brando Talaguit (ITC Developer)
*/
class User_M extends MY_Model
{
	protected $table_name 	= "user_account";
	protected $primary_key 	= "user_id";
	protected $order_by 	= "user_lname, user_fname, user_mname";
	protected $is_actived 	= "user_is_actived";
	protected $created_at   = "user_created_at";
	protected $updated_at   = "user_updated_at";
	protected $deleted_at   = "user_deleted_at";


	public $rules = array(
		'username' => array('field' => 'username', 'label' => 'username', 'rules' => 'trim|required|max_length[50]'),
		// 'username' => array('field' => 'username', 'label' => 'username', 'rules' => 'trim|required|max_length[50]|xss_clean'),
		'password' => array('field' => 'password', 'label' => 'password', 'rules' => 'trim|required')
	);

	public $rules_create_account = array(
		'user_lname' => array('field' => 'user_lname', 'label' => 'Lastname', 'rules' => 'trim|required'),
		'user_fname' => array('field' => 'user_fname', 'label' => 'Firstname', 'rules' => 'trim|required'),
		'user_mname' => array('field' => 'user_mname', 'label' => 'Middlename', 'rules' => 'trim|required'),
		'user_emp_email' => array('field' => 'user_emp_email', 'label' => 'Email', 'rules' => 'trim|required'),
		'blocked' => array('field' => 'blocked', 'label' => 'Status', 'rules' => 'trim|required'),
		'user_name' => array('field' => 'user_name', 'label' => 'Username', 'rules' => 'trim|required'), //|is_unique[user_account.user_name]
		'user_passkey' => array('field' => 'user_passkey', 'label' => 'Password', 'rules' => 'trim|required'),
		'repassword' => array('field' => 'repassword', 'label' => 'Confirm Password', 'rules' => 'trim|required|matches[user_passkey]'),
	);

	public $options = array(
	      						'user_lname' =>'Last Name',
	      						'user_fname' =>'First Name',
	      						'user_emp_email' =>'Email',
	      						'user_name' =>'Username',
	      						'blocked' =>'Block',
      						);

	function __construct()
	{
		parent::__construct();
	}


	public function login()
	{
		$this->load->model(['college_m']);

		// $this->db->where_in('user_type',array('R','S'));
		$user = $this->get_by(array(
			'user_name' => $this->input->post('username'),
			'user_passkey' => $this->hash($this->input->post('password'))
		), TRUE);

		// dump($user);
		// exit();

		if (count($user))
		{
			# Log in user
			$data = array(
				'lastname' => ucwords(strtolower($user->user_lname)),
				'firstname' =>  ucwords(strtolower($user->user_fname)),
				'middlename' =>  ucwords(strtolower($user->user_mname)),
				'username' => $user->user_name,
				'Id' => $user->user_id,
				'user_type'=>$user->user_department,
				'email_address' => $user->user_emp_email,
				'logged_in' => TRUE
			);

			// $access = $this->db->where('user_id', $user->user_id)->get('tbluseraccess')->result();
			

			// if (count($access))
			// {
			// 	foreach ($access as $role)
			// 	{
			// 		$data['data_access'][] = (INT) $role->access_id;
			// 	}
			// }
			$this->db->where('IsArchived', '1');
			$data['college']=$this->college_m->get();
			dump($this->db->last_query());

			$this->get_sysem();
			$this->session->set_userdata($data);
			dump($this->session->userdata());
			exit();
		}
		return $this->logged_in();
	}


	public function logged_in()
	{
		return (bool) $this->session->userdata('logged_in');
	}

	public function logout()
	{
		$this->session->sess_destroy();
	}

	public function get_new()
	{
		$user = new stdClass();
		$user->user_lname = '';
		$user->user_fname = '';
		$user->user_mname = '';
		$user->user_name = '';
		$user->user_passkey = '';
		$user->user_department = '';
		$user->user_curriculum_ids = '';
		$user->user_emp_email = '';
		$user->user_emp_id = '';
		$user->blocked = '';

		return $user;
	}

	public function hash($string)
	{
		return hash('sha512', $string . ENCRYPT_KEY);
		// return hash('md5', $string);
	}

	public function get_college()
	{
		$college = $this->db->get('tblcollege');

		$opt[' '] ="Select Colleges";

		foreach ($college->result() as $key => $college_val) 
		{
			$opt[$college_val->CollegeId] = $college_val->CollegeCode;
		}
		return $opt;
	}

	public function get_curriculum()
	{
		$curr = $this->db->get('tblcurriculum');

		$opt[' '] ="Select Curriculum";

		foreach ($curr->result() as $key => $curr_val) 
		{
			$opt[$curr_val->CurriculumId] = $curr_val->CurriculumDesc;
		}
		return $opt;
	}

	public function get_sysem()
	{

		$this->db->select('A.EnrollmentDateStart,A.EnrollmentDateEnd,B.*,C.*');
	    $this->db->from('tblsysem as A');
	    $this->db->join('tblsem as B','A.SemId = B.SemId');
	    $this->db->join('tblsy as C','A.SyId = C.SyId');
	    $this->db->where('IsCurrentSem','1');
	    // $this->db->where(array('A.SyId'=>'11','A.SemId'=>'1'));
	    $query['sysem'] = $this->db->get()->row();
	  	
		$this->session->set_userdata($query);

	    $this->db->close();
	}

	public function get_staff()
	{
		$option = [];
		$user = $this->get();

		foreach ($user as $key => $row) {
			$option[$row->user_id]=array('Fullname' => $row->user_lname .', '. $row->user_fname,'Username'=>$row->user_name,'Fname'=>$row->user_fname);
		}

		return $option;
	}

}

/*Location: ./application/models/user_m.php*/
