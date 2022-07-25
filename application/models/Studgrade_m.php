<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Studgrade_m extends MY_Model {

	protected $table_name = 'tblstudgrade';
    protected $primary_key = "studgrade_id";
    protected $order_by = "nametable";

    protected $timestamps = TRUE;

	public function __construct()
	{
		parent::__construct();
		
	}


	public function get_student_inc_grades($student_id)
	{
		$this->db->select('studgrade_id, StudNo, nametable, subject_id, C.leclab, CourseCode, CourseDesc, B.units, Grade, StrGrade, LabGrade, StrLab, RVal, RValLab, Remarks, IsLapsed, IsCompleted, B.faculty_id, concat(Lastname,", ", Firstname, " ", Middlename) as profname', FALSE);
		$this->db->join('tblsched B', 'nametable = Cfn', 'inner');
		$this->db->join('tblcourse C', 'C.CourseId = subject_id', 'inner');
		$this->db->join('tblfacultydisplay D', 'D.faculty_id = B.faculty_id', 'left');
		// $this->db->where('IsLapsed !=', '1');
		$this->db->where('(strgrade = "INC" || grade like "6.%" || remarks = "INCOMPLETE")', NULL, FALSE);
		
		return parent::get_by(['StudNo' => $student_id]);
	}

	public function get_student_grades($student_id)
	{
		$this->db->select('
			studgrade_id,
			StudNo,
			nametable,
			subject_id,
			C.leclab,
			CourseCode,
			CourseDesc,
			B.units,
			Grade,
			StrGrade,
			LabGrade,
			StrLab,
			RVal,
			RValLab,
			Remarks,
			B.SyId,
			B.SemId,
			SyDesc,
			SemDesc,
			SemCode
			', FALSE);
		$this->db->join('tblsched B', 'nametable = Cfn', 'inner');
		$this->db->join('tblcourse C', 'C.CourseId = subject_id', 'inner');
		$this->db->join('tblfacultydisplay D', 'D.faculty_id = B.faculty_id', 'left');
		$this->db->join('tblsy sy', 'sy.SyId = B.SyId', 'left');
		$this->db->join('tblsem sem', 'sem.SemId = B.SemId', 'left');
		$this->db->order_by('B.SyId,B.SemId', 'asc');		
		return parent::get_by(['StudNo' => $student_id]);
	}

}

/* End of file Studgrade_m.php */
/* Location: ./application/models/Studgrade_m.php */


