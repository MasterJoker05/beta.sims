<?php 

class Cmat_m extends MY_Model
{	

	protected $table_name = "umakunil_integrated.tblstudcmat";
	protected $primary_key = "cmat_id";	
	protected $order_by = "";
	protected $SySem = NULL;
	protected $isactive = FALSE;
    protected $soft_delete = FALSE;
	

	public function __construct()
	{
		parent::__construct();

		// Array of Academic Year	
	}

	public function get_all($SyId = NULL, $SemId = NULL) {
		$condition = array('SyId' => "$SyId",
	 					   'SemId' => "$SemId");

		$this->db->select('tblstudcmat.*,a.*,c.*',FALSE);
		$this->db->join('tblstudinfo as a', 'a.StudNo = tblstudcmat.StudNo', 'left');
		$this->db->join('tblstudcurriculum as b', 'b.StudNo = tblstudcmat.StudNo', 'left');
		$this->db->join('tblcurriculum as c', 'c.CurriculumId = b.CurriculumId', 'left');
		$this->db->join('tblstudcmatreprint as d', 'd.cmat_id = tblstudcmat.cmat_id and d.is_actived','left');
		$this->db->where("confirm_at > 0");
		$this->db->where("tblstudcmat.is_actived = '1'"); 
		// $this->db->order_by('tblstudcmat.created_at');
		return $this->Cmat_m->get_by($condition);
	}

	public function get_approval($SyId = NULL, $SemId = NULL) {
		$condition = array('SyId' => "$SyId",
	 					   'SemId' => "$SemId");

		$this->db->select('tblstudcmat.*,a.*,c.*',FALSE);
		$this->db->join('tblstudinfo as a', 'a.StudNo = tblstudcmat.StudNo', 'left');
		$this->db->join('tblstudcurriculum as b', 'b.StudNo = tblstudcmat.StudNo', 'left');
		$this->db->join('tblcurriculum as c', 'c.CurriculumId = b.CurriculumId', 'left');
		$this->db->join('tblstudcmatreprint as d', 'd.cmat_id = tblstudcmat.cmat_id and d.is_actived','left');
		return $this->Cmat_m->get_by($condition);
	}

	public function get_approved($SyId = NULL, $SemId = NULL) {
		$condition = array('SyId' => "$SyId",
	 					   'SemId' => "$SemId");

		$this->db->select('tblstudcmat.*,a.*,c.*',FALSE);
		$this->db->join('tblstudinfo as a', 'a.StudNo = tblstudcmat.StudNo', 'left');
		$this->db->join('tblstudcurriculum as b', 'b.StudNo = tblstudcmat.StudNo', 'left');
		$this->db->join('tblcurriculum as c', 'c.CurriculumId = b.CurriculumId', 'left');
		$this->db->join('tblstudcmatreprint as d', 'd.cmat_id = tblstudcmat.cmat_id and d.is_actived','left');
		return $this->Cmat_m->get_by($condition);
	}

	public function get_disapproved($SyId = NULL, $SemId = NULL) {
		$condition = array('tblstudcmat.SyId' => "$SyId",
	 					   'tblstudcmat.SemId' => "$SemId");

		$this->db->select('tblstudcmat.*,a.*,c.*',FALSE);
		$this->db->join('tblstudinfo as a', 'a.StudNo = tblstudcmat.StudNo', 'left');
		$this->db->join('tblstudcurriculum as b', 'b.StudNo = tblstudcmat.StudNo', 'left');
		$this->db->join('tblcurriculum as c', 'c.CurriculumId = b.CurriculumId', 'left');
		$this->db->join('tblpayment as d', 'd.cmat_id = tblstudcmat.cmat_id', 'left');
        $this->db->where("disapproved_note IS NOT NULL AND TRIM(disapproved_note) <> ''", NULL, FALSE);
		return $this->Cmat_m->get_by($condition);
	}

	public function get_printed($SyId = NULL, $SemId = NULL) {
		$condition = array('tblstudcmat.SyId' => "$SyId",
	 					   'tblstudcmat.SemId' => "$SemId");

		$this->db->select('tblstudcmat.*,a.*,c.*');
		$this->db->join('tblstudinfo as a', 'a.StudNo = tblstudcmat.StudNo', 'left');
		$this->db->join('tblstudcurriculum as b', 'b.StudNo = tblstudcmat.StudNo', 'left');
		$this->db->join('tblcurriculum as c', 'c.CurriculumId = b.CurriculumId', 'left');
        $this->db->where("tblstudcmat.approved_at > 0 ");
		$this->db->where("tblstudcmat.printed_at > 0 ");
		$this->db->where("tblstudcmat.confirm_at > 0 ");
		$this->db->where("tblstudcmat.is_actived = '1'");
		return $this->Cmat_m->get_by($condition);
	}

	public function get_cmat_load($cmat_id, $SyId = NULL, $SemId = NULL) {


		$condition = array('tblstudcmat.SyId' => "$SyId",
	 					   'tblstudcmat.SemId' => "$SemId");

		$this->db->select('tblstudcmat.*,A.*,B.*,C.*');
		$this->db->join('tblstudcmatloads as A', 'A.cmat_id = tblstudcmat.cmat_id', 'left');
		$this->db->join('tblsched as B', 'A.cfn_to = B.cfn', 'left');
		$this->db->join('tblcourse as C', 'B.subject_id = C.CourseId', 'left');
		$this->db->where('tblstudcmat.cmat_id', $cmat_id);
		$this->db->where("cfn_to > ''");
		$this->db->where("A.is_actived = 1");
		$this->db->order_by('A.cfn_to', 'desc');
		return $this->Cmat_m->get_by($condition);
	}

	public function get_cmat_final_load($cmat_id) {

		$this->db->select('*');
		$this->db->join('tblsched as B', 'A.cfn = B.cfn', 'left');
		$this->db->join('tblcourse as C', 'B.subject_id = C.CourseId', 'left');
		$this->db->join('tblyrsec as D', 'B.YearSectionId = D.Id', 'left');
		$this->db->where('A.cmat_id', $cmat_id);
		$this->db->where("A.Status = ''");
		$this->db->where("A.is_actived = 1");
		$this->db->order_by('A.cfn', 'desc');
		return $this->db->get('tblstudcmatprintlogs as A')->result();
	}
}

?>

