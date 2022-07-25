<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Completion_m extends MY_Model {

	protected $table_name = 'tblstudcompletion';
    protected $primary_key = "completion_id";
    protected $order_by = "completion_id";

    protected $is_actived = "inc_is_actived";
    protected $created_at = "inc_created_at";
    protected $updated_at = "inc_updated_at";
    protected $deleted_at = "inc_deleted_at";

    public $rules = array(        
        'inc_studno' => array('field' => 'inc_studno', 'label' => 'Student ID', 'rules' => 'trim|t|required|max_length[10]'),
        'inc_code' => array('field' => 'inc_code', 'label' => 'Course Code', 'rules' => 'trim|required|t|max_length[50]'),
        'inc_title' => array('field' => 'inc_title', 'label' => 'Course Title', 'rules' => 'trim|required|t|max_length[200]'),
        'inc_units' => array('field' => 'inc_units', 'label' => 'Major', 'rules' => 'trim|required|to_decimal'),
        'inc_semester' => array('field' => 'inc_semester', 'label' => 'Semester', 'rules' => 'trim|required|t|max_length[10]'),
        'inc_acadyear' => array('field' => 'inc_acadyear', 'label' => 'Academic Year', 'rules' => 'trim|required|t|max_length[10]|callback__valid_ay'),
        'inc_college' => array('field' => 'inc_college', 'label' => 'College Code', 'rules' => 'trim|required|t|max_length[10]'),
        'inc_stud_program' => array('field' => 'inc_stud_program', 'label' => 'Program', 'rules' => 'trim|required|t|max_length[200]'),
        'inc_requirements[]' => array('field' => 'inc_requirements[]', 'label' => 'Completion Requirements', 'rules' => 'trim|required|t|max_length[200]'),
        'inc_cfn' => array('field' => 'inc_cfn', 'label' => 'Course Filename (CFN)', 'rules' => 'trim|required|t|max_length[10]'),
        'inc_grading_sys' => array('field' => 'inc_grading_sys', 'label' => 'Grading System', 'rules' => 'intval|required'),
        'inc_grade' => array('field' => 'inc_grade', 'label' => 'Grade', 'rules' => 'trim|required|to_decimal|max_length[5]'),
        'inc_labgrade' => array('field' => 'inc_labgrade', 'label' => 'Lab. Grade', 'rules' => 'trim|required|to_decimal|max_length[5]'),
        'inc_date' => array('field' => 'inc_date', 'label' => 'Completion Date', 'rules' => 'trim|required|mysql_date'),
        'inc_professor_name' => array('field' => 'inc_professor_name', 'label' => 'Professor Name', 'rules' => 'trim|required|t|max_length[100]'),
        // 'inc_number' => array('field' => 'inc_number', 'label' => 'Completion Number', 'rules' => 'trim|required|t|max_length[10]|is_unique['.$this->table_name.'.inc_number]'),
        'inc_receipt_no' => array('field' => 'inc_receipt_no', 'label' => 'OR Number', 'rules' => 'trim|required|t|max_length[10]|callback__check_receipt_no'),
        'inc_validated_by' => array('field' => 'inc_validated_by', 'label' => 'Validated by', 'rules' => 'trim|required|t|max_length[100]'),
        'inc_validation_date' => array('field' => 'inc_validation_date', 'label' => 'Validated by', 'rules' => 'trim|required|mysql_date'),
        'IsOldSubject' => array('field' => 'IsOldSubject', 'label' => '', 'rules' => 'intval|trim'),
    );

	public function __construct()
	{
		parent::__construct();
		
	}


}

/* End of file Completion_m.php */
/* Location: ./application/models/Completion_m.php */


