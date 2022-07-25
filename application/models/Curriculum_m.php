<?php
class Curriculum_m extends MY_Model {

    protected $table_name = 'tblcurriculum';
    protected $primary_key = "CurriculumId";
    protected $order_by = "CurriculumDesc";

    protected $timestamps = FALSE;

    protected $protected_attribute = array(
        'is_actived', 'created_at', 'updated_at', 'deleted_at'
    );

    public $_select = array();

    public $rules = array(
        
        'CollegeDesc' => array('field' => 'CollegeDesc', 'label' => 'Description', 'rules' => 'trim|required|t|max_length[255]'),
        'CollegeId' => array('field' => 'CollegeId', 'label' => 'College', 'rules' => 'trim|required|t|max_length[255]'),
        'Program' => array('field' => 'College', 'label' => 'Program', 'rules' => 'trim|required|t|max_length[11]'),
        'Major' => array('field' => 'College', 'label' => 'Major', 'rules' => 'trim|required|t|max_length[11]'),
        'NoOfSem' => array('field' => 'CollegeCode', 'label' => 'Number of Sem', 'rules' => 'trim|required|t|max_length[11]'),
        'ProgramType' => array('field' => 'CollegeCode', 'label' => 'Program Type', 'rules' => 'trim|required|t|max_length[11]'),
    );

    public $options = array(
                                'name' =>'Curriculum Name',
                                'CollegeCode' =>'College Code',
                            );

    public function __construct()
    {
        parent::__construct();
    }

    public function get_curriculum()
    {
    	$data = array();
    	$data = $this->db
    		->select('a.*, b.CollegeCode, b.CollegeDesc, c.ProgramCode, c.ProgramDesc, d.MajorCode, d.MajorDesc')    	
	    	->join('tblcollege as b','a.collegeid = b.collegeid','left')
	        ->join('tblprogram as c','a.programid = c.programid','left')
	        ->join('tblmajor as d','a.majorid = d.majorid','left')
	        ->order_by('b.CollegeCode, c.ProgramDesc, d.MajorCode')
	        ->get('tblcurriculum as a')
	        ->result_array();

	    return $data;
    }

    public function get_student_info($StudNo)
    {
    	$data = array();
    	$data = $this->db->where('StudNo',$StudNo)->get('tblstudinfo')->result_array();

    	return $data;
    }

    public function get_enroll_trans($student_id=NULL, $single = FALSE, $return_type = 'object')
    {
        $this->_select = [
            'O.SemCode',
            'N.SyDesc',
            'IF(IsEncoded = 1, DATE_FORMAT(EncodedDateTimeEnd, "%b %d %Y"), "") as IsEncoded',
            'IF(IsCOROfficial = 1 OR IsPrinted = 1, IF(IsPrinted=1, DATE_FORMAT(DatePrint, "%b %d %Y"), DATE_FORMAT(DateOfficialCOR, "%b %d %Y")), "") as IsCorOfficial',
            'CONCAT(IF(IsCancelled = 1, CONCAT("<li>Enrollment Cancelled ", DateCancelled, "</li>"),
                IF(IsCOROfficial = 1 OR IsPrinted = 1, "<li>with COR</li>", 
                    IF(IsEncoded = 0 OR IsEncoded IS NULL, 
                        "<li>Not Encoded</li>", 
                        CONCAT("<li>Date Encoded on the ", DATE_FORMAT(EncodedDateTimeEnd, "%D of %M %Y"), "</li>")
                    )
                )
             ), IF(IsTCP = 1 OR IsGraduateProgram = 1, "<li>Graduate/TCP Program</li>", ""
            ), IF(IsScholar = 1, CONCAT("<li>TASC approved scholarship on the ", DATE_FORMAT(M.approved_date, "%D of %M %Y"), "</li>"), ""), 
               IF(IsPromissory = 1, "<li>with Promissory Note</li>", "")
            ) as Status',
        ];
        

        return self::get_student($student_id, $single, $return_type);
    }

    public function get_student($student_id = NULL, $single = FALSE, $return_type = 'object')
    {

        $student_id !== NULL && $this->db->where('A.StudNo', $student_id);

        $method = $single ? 'row' : 'result';


        $select = $this->_select ? $this->_select : [
            'A.StudNo',
            'Lname',
            'Fname',
            'Mname',
            'CollegeCode',
            'CollegeDesc',
            'CurriculumDesc',
            'ProgramDesc',
            'MajorDesc',
            'IsTCP',
            'IsGraduateProgram',
            'Controlled',
            'IsControlled',
            'IsEncoded',
            'IsCorOfficial',
            'DateOfficialCOR',
            'IF(IsPromissory IS NULL, IF(PayMode="PROMISSORY", 1, 0), IsPromissory) IsPromissory',
            'Guardian',
            'AddressStreet',
            'AddressBarangay',
            'AddressCity',
            'IsMakatiResident',
            'IF(IsMakatiResident = 1, "Makati", "Non-Makati") as Residency',
            'VotersCertificate',
            'LengthOfStayBySem',
            'BirthDay',
            'H.ScholarshipId',
            'ScholarshipDesc',
            'DiscountPercentage',
            'ScholarshipTypeId',
            'FullScholarship',
            'Requirements',
            // 'IsScholar',
            // 'IsPromissory',
            'CONCAT(IF(IsCancelled = 1, CONCAT("<li>Enrollment Cancelled ", DateCancelled, "</li>"),
                IF(IsCOROfficial = 1, "<li>with COR</li>", 
                    IF(IsEncoded = 0 OR IsEncoded IS NULL, 
                        "<li>Not Yet Encoded</li>", 
                        CONCAT("<li>Date Encoded on the ", DATE_FORMAT(EncodedDateTimeEnd, "%D of %M %Y"), "</li>")
                    )
                )
             ), IF(IsTCP = 1 OR IsGraduateProgram = 1, "<li>Graduate/TCP Program</li>", ""
            ), IF(IsScholar = 1, CONCAT("<li>TASC approved scholarship on the ", DATE_FORMAT(M.approved_date, "%D of %M %Y"), "</li>"), ""), 
               IF(IsPromissory = 1, "<li>with Promissory Note</li>", "")
            ) as Status',
        ];

        $this->db
            ->select($select, FALSE)
            // ->join('umakunil_feval.tblstudemailaccount as B','A.StudNo = B.StudNo','left')
            ->join('tblstudcurriculum as C','C.StudNo = A.StudNo', 'left')
            ->join('tblcurriculum as D','D.CurriculumId = C.CurriculumId', 'left')
            ->join('tblcollege as E','E.CollegeId = D.CollegeId', 'left')
            ->join('tblmajor as I','D.MajorId = I.MajorId', 'left')
            ->join('tblprogram as J','D.ProgramId = J.ProgramId', 'left')
            ->join('tblenrollmenttrans as F', 'F.StudNo = A.StudNo', 'left')
            ->join('tblstudentscholar as G', 
                    'G.StudNo = F.StudNo AND G.SyId = F.SyId AND G.SemId = F.SemId', 'left')
            ->join('tblscholarship as H','H.ScholarshipId = G.ScholarshipId', 'left')
            ->join('tblpaymentmode as L', 
                    'L.StudNo = A.StudNo AND L.SyId = F.SyId AND L.SemId = F.SemId', 'left')
            ->join('tblscholarshiptrans as M', "M.StudNo = A.StudNo AND M.SyId = F.SyId AND M.SemId = F.SemId AND M.is_actived = 1", 'left')            
            ->join('tblsy as N', 'F.SyId = N.SyId')
            ->join('tblsem as O', 'F.SemId = O.SemId')
            ->order_by('F.SyId, F.SemId, Lname, Fname, Mname', 'desc')
            ;

        
        $result = $this->db->get('tblstudinfo' .' as A');


        if ($return_type == 'resource') 
        return $result;

        $return_type == 'array' && $method .= '_array';

        return $result->$method();
    }

    public function get_student_by($where, $single = FALSE, $return_type = 'object')
    {
        $where !== NULL && $this->db->where($where, NULL, FALSE);
        return self::get_student(NULL, $single, $return_type);
    }

    public function table_generate($table = [], $heading = NULL)
    {
        $this->load->library('table');

        $template = array(
                'table_open'  => '<div class="table-responsive "><table class="table table-bordered table-condensed table-striped table-hover">',
                'table_close' => '</table></div>'
        );

        $heading && $this->table->set_heading($heading);

        $this->table->set_template($template);

        return $this->table->generate($table);
    }

    public function get_student_profile($student_id = NULL)
    {
        $data = $this->db
                ->select('CurriculumDesc, d.CollegeId, e.CollegeCode, e.CollegeDesc, c.CurriculumId, ProgramCode, ProgramDesc, MajorCode, MajorDesc, a.*', FALSE)
                ->join('tblstudcurriculum as c','a.StudNo = c.StudNo','left')
                ->join('tblcurriculum as d','c.CurriculumId = d.CurriculumId','left')
                ->join('tblcollege as e','e.CollegeId = d.CollegeId','left')

                ->join('tblprogram as f','f.programid = d.programid','left')
                ->join('tblmajor as g','g.majorid = d.majorid','left')

                ->where('a.StudNo', $student_id)

                ->order_by('stud_curr_id', 'desc')
                ->limit(1)
                ->get('tblstudinfo as a')

                ->row();

        return $data;
    }

    public function get_active_curriculum($SyId = NULL,$SemId = NULL,$CollegeCode = NULL)
    {
        $condition = 
            [
                'SyId'       => $SyId,
                'SemId'      => $SemId,
                'IsEncoded'  => 1,
                'IsCOROfficial' => 1,
                'IsAssessed' => 1,
                'e.CollegeCode'=> $CollegeCode

            ]
        ;
        $data = $this->db
            ->select('CurriculumDesc,d.CollegeId,e.CollegeCode,e.CollegeDesc,c.CurriculumId, count(a.StudNo) as cnt',FALSE)       
            ->join('tblstudinfo as b','a.StudNo = b.StudNo','left')
            ->join('tblstudcurriculum as c','a.StudNo = c.StudNo','left')
            ->join('tblcurriculum as d','c.CurriculumId = d.CurriculumId','left')
            ->join('tblcollege as e','e.CollegeId = d.CollegeId','left')
            ->order_by('d.CollegeId,d.CurriculumDesc')
            ->where($condition)
            ->group_by('d.CollegeId,d.CurriculumDesc')
            ->get('tblenrollmenttrans as a')
            ->result();

        return $data;
    }

    public function get_active_per_curriculum($SyId = NULL,$SemId = NULL,$CollegeCode = NULL,$CurrId = NULL)
    {
        $condition = 
            [
                'SyId'       => $SyId,
                'SemId'      => $SemId,
                'IsEncoded'  => 1,
                'IsAssessed' => 1,
                'IsCOROfficial' => 1,
                'e.CollegeCode'=> $CollegeCode,
                'c.CurriculumId'=> $CurrId,

            ]
        ;
        $data = $this->db
            ->select('CurriculumDesc,d.CollegeId,e.CollegeCode,e.CollegeDesc,c.CurriculumId,Lname,Fname,Mname,LengthOfStayBySem,a.StudNo',FALSE)       
            ->join('tblstudinfo as b','a.StudNo = b.StudNo','left')
            ->join('tblstudcurriculum as c','a.StudNo = c.StudNo','left')
            ->join('tblcurriculum as d','c.CurriculumId = d.CurriculumId','left')
            ->join('tblcollege as e','e.CollegeId = d.CollegeId','left')
            ->order_by('Lname,Fname,StudNo')
            ->where($condition)
            ->get('tblenrollmenttrans as a')
            ->result();

        return $data;
    }

    public function get_active_student($SyId = NULL,$SemId = NULL,$StudNo = NULL)
    {
        $condition = 
            [
                'SyId'       => $SyId,
                'SemId'      => $SemId,
                'IsEncoded'  => 1,
                // 'IsAssessed' => 1,
                'IsCOROfficial' => 1,
                'a.StudNo'=> $StudNo

            ]
        ;
        $data = $this->db
            ->select('CurriculumDesc,d.CollegeId,e.CollegeCode,e.CollegeDesc,c.CurriculumId,b.*',FALSE)       
            ->join('tblstudinfo as b','a.StudNo = b.StudNo','left')
            ->join('tblstudcurriculum as c','a.StudNo = c.StudNo','left')
            ->join('tblcurriculum as d','c.CurriculumId = d.CurriculumId','left')
            ->join('tblcollege as e','e.CollegeId = d.CollegeId','left')
            ->order_by('Lname,Fname,StudNo')
            ->where($condition)
            ->get('tblenrollmenttrans as a')
            ->result();

        return $data;
    }


    public function get_college($CollegeId = NULL)
    {
        $data = $this->db
            ->select('CollegeCode',FALSE)       
            ->where('CollegeId',$CollegeId)
            ->get('tblcollege')
            ->row();

        return $data;
    }

    public function get_new()
    {
        $college = new stdClass();
        $college->CollegeCode = '';
        $college->CollegeDesc = '';

        return $college;
    }

    public function count($where = NULL)
    {
        $this->db->join('tblcollege', 'tblcurriculum.CollegeId=tblcollege.CollegeId', 'LEFT');
        return parent::count($where);
    }

    public function get($id = NULL, $single = FALSE)
    {
        $this->db->join('tblcollege', 'tblcurriculum.CollegeId=tblcollege.CollegeId', 'LEFT');
        return parent::get($id, $single);
    }


    public function search($page = 0, $limit)
    {
        $search_arr = array();
        
        
        $rules = array(
            'by' => array('field' => 'by', 'label' => 'Search By',
                            'rules' => 'trim'),
            'Search' => array('field' => 'Search', 'label' => 'Search Text',
                            'rules' => 'trim|t'),
        );
        
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == TRUE)
        {
            $by = $this->input->post('by');
            $search = $this->input->post('Search');

            $search_field = array(
                                    'by' => $by,
                                    'search' => $search,
                                );

            if ( $by && $search )
            {
                if ($by == 'name')
                {
                    $param1 = ["(CurriculumDesc LIKE '%{$search}%')" => NULL];
                }
                elseif (in_array($by, array_keys($this->data['options'])))
                {
                    $param1 = [$by => "'$search'"];
                }
            }

            $param1 == FALSE || $search_arr = array_merge($search_arr, $param1);

            $this->session->set_userdata([
                    'filter_result' => $search_arr,
                    'filter_field' => $search_field,
                ]);

            return redirect('curriculum');
        }
        else
        {
            if ($this->session->userdata('filter_result') != NULL)
            {
                $search_arr = $this->session->userdata('filter_result');
            }
        }

        return [];
    }


    public function validation($skip = FALSE) 
    {
        if($skip !== TRUE) {

            $this->form_validation->set_rules($this->rules);

            if ($this->form_validation->run() == FALSE)
            {  
                return validation_errors();
            }
        }
        return TRUE;
    }
}