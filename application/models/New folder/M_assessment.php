<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: Brando
 * Date: 8/30/11
 * Time: 1:17 PM
 * To change this template use File | Settings | File Templates.
 */

class M_assessment extends CI_Model
{
    public $SyId = 0;
    public $SemId = 0;
    function __construct()
    {
        parent::__construct();
        $this->SyId = $_SESSION['session']['sy_sem']['SyId'];
        $this->SemId = $_SESSION['session']['sy_sem']['SemId'];
    }

    public function _is_coahs_assessed($StudNo, $SyId, $SemId)
    {

        $condition = array(
            'A.SyId' => $SyId,
            'A.SemId' => $SemId,
            'A.StudNo' => $StudNo,
            'A.is_actived' => 1,
            );

        $this->db
            ->where($condition)
            ->join('tbltuitions B', 'A.tuition_id = B.tuition_id', 'left');

        $assessment = $this->db->get('tblstudtuitions A')->row_array();

        // $this->db->close();

        return count($assessment) ? $assessment : FALSE;
    }

    public function _is_tuition_exists($StudNo, $SyId, $SemId)
    {
        $condition = array();

        // check if student is already assessed
        $assessment = $this->_is_coahs_assessed($StudNo, $SyId, $SemId);

        if ($assessment)
        {
            // $condition['tuition_id'] =  $assessment['tuition_id'];
            return $assessment;
        }
        else
        {
            $curriculum_id = $this->session->userdata('session')['student_curriculum']['CurriculumId'];

            if ($this->session->userdata('session')['student_curriculum']['CollegeId'] == 6)
            {
                $_SESSION['session']['enrollment_trans']['IsEncoded'] = 0;
                $_SESSION['session']['enrollment_trans']['IsAssessed'] = 0;
                $_SESSION['session']['enrollment_trans']['IsControlled'] = 0;
                $this->session->set_flashdata('error', '<b>Please Read: To save your schedule, please proceed or call COAHS Office for approval.</b>');
                redirect('student', 'refresh');

                $condition['LengthOfStayBySem'] = $this->session->userdata('session')['student_info']['LengthOfStayBySem'];
            }

            $condition = array(
                'curriculum_id' => $curriculum_id,
                'adjusted' => 0,
                'is_actived' => 1,
            );

            $this->db->where($condition);
            $tuition = $this->db->get('tbltuitions')->row_array();

        }

        return count($tuition) ? $tuition : FALSE;

    }

    public function get_payment_scheme($total_units, $total_rle_hrs, $total_lab_units, $misc_fee, $payment_scheme, $tuition)
    {
        $tuition_fee = floatval($tuition['rate_per_unit']) * floatval($total_units);
        $rle_fee = floatval($tuition['rle_rate_per_hour']) * floatval($total_rle_hrs);
        $lab_fee = floatval($tuition['lab_rate_per_unit']) * floatval($total_lab_units);
        $misc_fee = floatval($tuition['misc_fee']);

        $total_fees = $tuition_fee + $rle_fee + $lab_fee + $misc_fee;

        if ($payment_scheme == 1)
            $grand_total = $total_fees - ($tuition_fee * 0.10);
        elseif ($payment_scheme == 2)
            $grand_total = $total_fees;
        elseif ($payment_scheme == 3)
            $grand_total = $total_fees + (($total_fees - ($total_fees * 0.10)) * 0.05);
        else
            $grand_total = $total_fees;


        return array(
                    // 'rate_per_unit' => $tuition['rate_per_unit'],
                    // 'rle_rate_per_hour' => $tuition['rle_rate_per_hour'],
                    // 'lab_rate_per_unit' => $tuition['lab_rate_per_unit'],

                    'tuition_fee' => $tuition_fee,
                    'rle_fee' => $rle_fee,
                    'lab_fee' => $lab_fee,
                    'misc_fee' => $misc_fee,
                    'total_fees' => $total_fees,
                    'grand_total' => $grand_total,
                );
    }


    public function coahs_student_assess($StudNo, $SyId, $SemId, $tuition_id = NULL)
    {
        $tuition = $this->_is_tuition_exists($StudNo, $SyId, $SemId);

        if (empty($tuition))
        {
            $error = "No tuition fee details found. Please call the attention of the accounting office.";
            $this->M_enroll->set_user_logs($error);
            $this->session->set_flashdata('error', $error);

            return redirect('student','refresh');
        }

        if ($tuition_id == NULL)
        $tuition_id = $tuition['tuition_id'];

        // $student = $this->_is_coahs_assessed($StudNo, $SyId, $SemId);
        $payment_scheme = get_num($tuition, 'payment_scheme');

        $this->input->post('payment_scheme', TRUE) && $payment_scheme = $this->input->post('payment_scheme', TRUE);

        /*$payment_scheme = $this->input->post('payment_scheme') ? $this->input->post('payment_scheme') : $tuition['payment_scheme'];*/

        $t_units_sql = "SELECT SUM(IF(CourseCode NOT LIKE 'NSTP%', c.Units, 0)) as total_units FROM tblstudentschedule as a
                        LEFT JOIN tblsched as b ON a.Cfn = b.cfn
                        LEFT JOIN tblcourse as c on b.subject_id = c.CourseId
                        WHERE a.IsActive = 1 AND a.Status = '' AND b.SyId = {$SyId} AND b.SemId = {$SemId} AND a.StudNo = '{$StudNo}'";
        $t_units = $this->db->query($t_units_sql)->row();

        $t_rle_sql = "SELECT SUM(RleHrs) as total_rle_hrs FROM tblstudentschedule as a
                        LEFT JOIN tblsched as b ON a.Cfn = b.cfn
                        LEFT JOIN tblcourse as c on b.subject_id = c.CourseId
                        WHERE a.IsActive = 1 AND a.Status = '' AND b.SyId = {$SyId} AND b.SemId = {$SemId} AND a.StudNo = '{$StudNo}'";
        $t_rle = $this->db->query($t_rle_sql)->row();

        $t_lab_sql = "SELECT SUM(LabUnits) as total_lab_units FROM tblstudentschedule as a
                        LEFT JOIN tblsched as b ON a.Cfn = b.cfn
                        LEFT JOIN tblcourse as c on b.subject_id = c.CourseId
                        WHERE a.IsActive = 1 AND a.Status = '' AND b.SyId = {$SyId} AND b.SemId = {$SemId} AND a.StudNo = '{$StudNo}'";
        $t_lab = $this->db->query($t_lab_sql)->row();

        $assessment = $this->get_payment_scheme($t_units->total_units, $t_rle->total_rle_hrs, $t_lab->total_lab_units, $tuition['misc_fee'], $payment_scheme, $tuition);

        $data = array(
            'SyId'  => $SyId,
            'SemId' => $SemId,
            'StudNo' => $StudNo,
            'payment_scheme' => $payment_scheme,

            'tuition_id' => $tuition['tuition_id'],

            'no_units' => $t_units->total_units,
            'tuition_fee' => $assessment['tuition_fee'],
            'no_rle_hours' => $t_rle ? $t_rle->total_rle_hrs : 0.00,

            'rle_fee' => $assessment['rle_fee'],
            'no_lab_units' => $t_lab ? $t_lab->total_lab_units : 0.00,

            'lab_fee' => $assessment['lab_fee'],
            'misc_fee' =>  $assessment['misc_fee'],
            'grand_total' => $assessment['grand_total'],

        );

        return array_merge($data, $tuition);

    }


    public function get_coahs_assessment($StudNo, $SyId, $SemId)
    {
        $assessment = $this->_is_coahs_assessed($StudNo, $SyId, $SemId);

        // $this->db->close();

        if (count($assessment))
        {
            return $assessment;
        }

        return FALSE;
    }

    public function get_tuition_detail($StudNo, $SyId, $SemId)
    {
        $tuition = $this->_is_tuition_exists($StudNo, $SyId, $SemId);

        // $this->db->close();

        if ( count($tuition))
        {
            return $tuition;
        }

        return FALSE;
    }

    function has_scholarship($StudNo)
    {
        $scholar = $this->getScholarship($StudNo);

        // $this->db->close();

        if( ! empty($scholar))
            return TRUE;

        return FALSE;

    }

    // db where dept club fee
    function get_fees($college_id = NULL, $program_id = NULL, $major_id = NULL)
    {
        $this->db->select('A.*,B.*');
        $this->db->join('tblfees as B','A.FeeId = B.FeeId','inner');
        $this->db->from('tblassessmentinfo as A');

        if ($college_id !== NULL)
        $this->db->where('A.CollegeId', $college_id);

        if ($program_id !== NULL)
        $this->db->where('A.ProgramId', $program_id);

        if ($major_id !== NULL)
        $this->db->where('A.MajorId', $major_id);

        // Do Not INCLUDE Ingles Club
        if ($_SESSION['session']['sy_sem']['SemId'] != '1')
        {
            // ENG
            if ($college_id == 11 && in_array($program_id, array(15)) && in_array($major_id, array(9)))
            $this->db->where('A.FeeId !=', 33);

            // MATH
            if ($college_id == 11 && in_array($program_id, array(15)) && in_array($major_id, array(14)))
            $this->db->where('A.FeeId !=', 10);
        }

    }

    function getUnsetOrgFee($StudNo)
    {
        $condition  = array('StudNo' => $StudNo, 'is_actived' => 1, 'SyId' =>$this->SyId ,'SemId' =>$this->SemId);
        $this->db->where($condition);
        return $this->db->get('tblassessmenttrans_unset')->result_array();
    }

    function getStudentOrg($StudNo, $CollegeId, $ProgramId, $MajorId)
    {
        if ($_SESSION['session']['sy_sem']['SemId'] == '3') {
            return array();
        }
        // University Wide Fees
        // $fees = array(24, 25, 26, 31); // ssg, sgp, pia, group life insurance
        // $fees = array(24, 26, 31, 48);  // ssg, pia, group life insurance, CAF
        $fees = array(26, 48, 25, 53);  // includes USMG formely known as sgp, USC & removed ssg
        if ($_SESSION['session']['sy_sem']['SemId'] == '1')
        $fees[] = 31;

        // check if student has scholarship then include umak scholar feeid 22
        $scholar = $this->has_scholarship($StudNo);
        if ($scholar)
            $fees[] = 22;

        $this->get_fees($CollegeId, $ProgramId, $MajorId);
        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            if ($CollegeId == 11)
            {
                // $fees = array(24, 26, 31, 44); // ssg, pia, group life insurance, Young Educator's Society(YES) - COE
                $fees[] = 44; // Young Educator's Society(YES) - COE
            }

            if ($CollegeId == 6)
            {
                $fees[] = 49; // COAHS Research Society
            }

            $this->get_fees($CollegeId, $ProgramId, $MajorId);
            $this->db->or_where_in('B.FeeId', $fees);
            $query = $this->db->get();
        }
        else
        {

            if ($CollegeId == 11)
            {
                // $fees = array(24, 26, 31, 44); // ssg, pia, group life insurance, Young Educator's Society(YES) - COE
                $fees[] = 44; // Young Educator's Society(YES) - COE
            }

            if ($CollegeId == 6)
            {
                $fees[] = 49; // COAHS Research Society
            }



            $this->get_fees($CollegeId, $ProgramId, 0);
            $query = $this->db->get();


            if($query->num_rows() > 0)
            {
                $this->get_fees($CollegeId, $ProgramId, 0);
                $this->db->or_where_in('B.FeeId', $fees);
                $query = $this->db->get();
            }
            else
            {
                $this->get_fees($CollegeId, 0, 0);
                $this->db->or_where_in('B.FeeId', $fees);
                $query = $this->db->get();
            }


        }

        $row = array();


        if($query->num_rows() > 0)
        $row = $query->result_array();

        // $this->db->close();
        return $row;

    }


    /**
     * Assess per subject NSTP included here
     */

    function getAssPerSubject($StudNo)
    {
        if ($_SESSION['session']['sy_sem']['SemId'] == '3') {
            return array();
        }

        $this->db->query('SET SQL_BIG_SELECTS = 1');
        $this->db->select('D.AssId, A.*, H.CourseCode, E.*, COUNT(*) as cntr');
        $this->db->from('tblstudentschedule as A ');

        // $this->db->join('tblcoursesched as B','A.Cfn = B.Cfn','inner');
        $this->db->join('tblsched as B', 'A.Cfn = B.Cfn', 'inner');
        $this->db->join('tblcourse as H', 'H.CourseId = B.subject_id', 'inner');
        $this->db->join('tblassessmentinfo as D ', 'H.CourseCode =  D.CourseCode', 'inner');
        $this->db->join('tblfees as E ','D.FeeId = E.FeeId', 'inner');

        $this->db->where('A.StudNo', $StudNo);
        $this->db->where('A.SyId', $_SESSION['session']['sy_sem']['SyId']);
        $this->db->where('A.SemId', $_SESSION['session']['sy_sem']['SemId']);
        // $this->db->not_like('H.CourseCode', 'NSTP', 'after');
        // $this->db->where('H.CourseCode !=', 'NSTP 1');
        // $this->db->where('H.CourseCode !=', 'NSTP 2');
        $this->db->group_by('E.FeeId');
        $query = $this->db->get();

        $row = array();
        if($query->num_rows() > 0) {
            $row = $query->result_array();
        }

        $fil_subject = $this->getAssFilSubject($StudNo);
        if (is_array($fil_subject))
        $row[] = $fil_subject;

        // $this->db->close();
        return $row;
    }


    function getAssFilSubject($StudNo)
    {
        // prevent function execution
        return FALSE;

        $sy_id = $_SESSION['session']['sy_sem']['SyId'];
        $sem_id = $_SESSION['session']['sy_sem']['SemId'];
        $fil_curriculum = array('12', '111', '181');

        $this->db->where('StudNo', $StudNo);
        $curriculum = $this->db->get('tblstudcurriculum as A')->row_array();
        if ( ! in_array($curriculum['CurriculumId'], $fil_curriculum))
        {
            $filipino_schedule = array();
            $this->db->where('IsActive', 1);
            $this->db->like('CourseCode', 'FIL', 'after');
            $filipino_schedule = $this->db->where('StudNo', $StudNo)->where('A.SyId', $sy_id)->where('A.SemId',$sem_id)->join('tblsched as B','A.Cfn = B.cfn','left')->join('tblcourse as C','B.subject_id = C.CourseId','left')->order_by('A.Cfn')->get('tblstudentschedule as A')->result_array();

            if ( ! empty($filipino_schedule))
            {
                // KAFIL = 20.00
                $this->db->where('FeeId', 52);
                return $this->db->get('tblassessmentinfo')->row_array();
            }
        }

    }


    function getNSTPFEE($StudNo)
    {
        // $this->db->select('D.AssId, A.*, H.CourseCode, E.*, COUNT(*) as cntr');
        $this->db->from('tblstudentschedule as A ');

        $this->db->join('tblsched as B','A.Cfn = B.Cfn','left');
        $this->db->join('tblcourse as H','H.CourseId = B.subject_id','left');
        // $this->db->join('tblassessmentinfo as D ','H.CourseCode =  D.CourseCode','inner');
        // $this->db->join('tblfees as E ','D.FeeId = E.FeeId','inner');

        $this->db->where('A.StudNo',$StudNo);
        $this->db->where('A.SyId',$_SESSION['session']['sy_sem']['SyId']);
        $this->db->where('A.SemId',$_SESSION['session']['sy_sem']['SemId']);

        $this->db->like('H.CourseCode', 'NSTP', 'both');
        // $this->db->like('H.CourseCode', 'NSTP', 'after');
        // $this->db->where('(H.CourseCode = "NSTP 2" OR H.CourseCode ="NSTP 1")');

        // $this->db->group_by('E.FeeId');

        $nstp = $this->db->get();

        $row = array();
        if ($nstp->num_rows() > 0)
        {
            $this->db->from('tblassessmentinfo as D');
            $this->db->join('tblfees as E ','D.FeeId = E.FeeId','inner');
            $this->db->where('D.CourseCode', 'NSTP');
            $query = $this->db->get();
            $row = $query->result_array();
        }


        // $this->db->close();
        return $row;
    }

    public function get_nstp_payment($studno, $sy_id, $sem_id,$single = TRUE)
    {
        $this->db->select("*,bill_trans_no as ornum,bill_detail_fee_id as FeeId",FALSE);
        $this->db->join('tblbilling_detail as B','B.bill_detail_bill_id = A.bill_id','left')
                 ->join('tblfees as C','C.FeeId  = B.bill_detail_fee_id','left')
                 ->join('tblsy as D','D.SyDesc  = A.acad_year')
                 ->join('tblsem as E','E.SemId  = A.sem_id','left');

        $this->db->where('SyId',$sy_id);
        $this->db->where('SemId',$sem_id);
        $this->db->where('student_id',$studno);
        $this->db->where('bill_trans_date > 0');
        $this->db->where('bill_is_active',1);
        $this->db->where_in('C.FeeId', [51]);

        if ($single)
            $billing = $this->db->get('tblbilling as A')->row_array();
        else
            $billing = $this->db->get('tblbilling as A')->result_array();

        if (!empty($billing))
        {
            return $billing;
        }

        else
        {

            $this->db->where(array('StudNo' => $studno, 'SyId' => $sy_id, 'SemId' => $sem_id, 'FeeId' => 51, 'is_actived' => 1));
            $payment = $this->db->get('tblpayment')->row_array();

            return $payment;
        }
    }



     function getLabFee($StudNo)
    {
/*        $this->db->where('CollegeId',4);
        $this->db->where('ProgramId',11);
        $this->db->where('MajorId',1);
        $this->db->where('StudNo',$StudNo);
        $query = $this->db->get('tblstudcoursesched');*/
        // dump($this->session->userdata('session')['student_curriculum']['CollegeId']);
        // exit();
        if ($_SESSION['session']['sy_sem']['SemId'] == '3') {
            return array();
        }

        $row = array();
        // if($query->num_rows() > 0) {
        if($this->session->userdata('session')['student_curriculum']['CollegeId']==4 && $this->session->userdata('session')['student_curriculum']['ProgramId'] == 11 && $this->session->userdata('session')['student_curriculum']['MajorId'] == 1) {
            $this->db->select('A.*,B.*');
            $this->db->from('tblassessmentinfo as A');
            $this->db->join('tblfees as B','A.FeeId = B.FeeId','inner');
            $this->db->where('A.AssId',49);
            $query = $this->db->get();
        } else {
            $sql = "SELECT  COUNT( * ), IF( COUNT(*)>=2, 49, 7) as AssId,  B.FeeId, B.FeeDesc, IF( COUNT(*)>=2, 100.00, 50.00) as Amount
                    FROM tblassessmentinfo AS  A
                        INNER JOIN  tblfees AS B ON  A.FeeId = B.FeeId
                        INNER JOIN  tblstudentschedule AS C
                        INNER JOIN  tblsched AS E ON E.cfn = C.cfn
                        INNER JOIN  tblcourse AS D ON D.courseid = E.subject_id
                    WHERE  C.StudNo = '" . $StudNo
                     ."' AND C.SyId = " . $_SESSION['session']['sy_sem']['SyId']
                     ." AND C.SemId = " . $_SESSION['session']['sy_sem']['SemId']
                     ." AND D.WithComputerSubject = 1 AND
                        B.FeeId = 19
                    GROUP BY  B.FeeId";
            $query = $this->db->query($sql);
        }

        if($query->num_rows() > 0) {
            $row = $query->result_array();
        }

        // $this->db->close();
        return $row;
    }

    function getScholarship($StudNo)
    {
        $this->db->select('A.*,B.*');
        $this->db->from('tblstudentscholar as A ');
        $this->db->join('tblscholarship as B','A.ScholarshipId = B.ScholarshipId','inner');
        $this->db->where('A.StudNo', $StudNo);
        $this->db->where('A.SyId', $_SESSION['session']['sy_sem']['SyId']);
        $this->db->where('A.SemId', $_SESSION['session']['sy_sem']['SemId']);
        $query = $this->db->get()->row_array();

        return $query;

    }


    function getIDFee($StudNo)
    {
        $row = array();
        // remove ID Fee from misc fee collection
        // return $row;

        $transferee = substr($StudNo, 1, 1) . substr($_SESSION['session']['sy_sem']['SyCode'], 0, 2) == '6'. substr($_SESSION['session']['sy_sem']['SyCode'], 0, 2);
        $new_stud_id = 'A' . $_SESSION['session']['sy_sem']['SemId'] . substr($_SESSION['session']['sy_sem']['SyCode'], 0, 2) == substr($StudNo, 0, 4);

        // check if student has no copy of notice of admission
        $this->db->where('StudNo', $StudNo);
        $this->db->where('is_actived', 1);
        $this->db->where('SyId', config_item('noa_sy_id'));
        $this->db->where('SemId', config_item('noa_sem_id'));
        $tasc = $this->db->get(DBTASC . 'exam_results')->row();
        if ( ! empty($tasc))
        {
            if ($tasc->IsPrinted == '1')
            {
                $new_stud_id = TRUE;
            }
        }

        if ($new_stud_id == TRUE)
        {
            $fee_id = 37;
            $this->db->where(['FeeId' => $fee_id, 'StudNo' => $StudNo]);
            $umak_id = $this->db->get('tblpaymentmisc');
            // $this->db->close();

            if ($umak_id->num_rows()>0)
            return $row;

            $this->db->select('A.*,B.*');
            $this->db->from('tblassessmentinfo as A');
            $this->db->join('tblfees as B','A.FeeId = B.FeeId','inner');
            $this->db->where('A.AssId', 76);

            $row = $this->db->get()->result_array();
        }

        // $this->db->close();
        return $row;
    }


    function assessmentISO($StudNo, $SemId, $SyId, $time_start)
    {
       $condition = array(
           'StudNo' => $StudNo,
           'SyId' => $SyId,
           'SemId' => $SemId
       );

       $data = $this->db->where($condition)->get('tblassessmentiso');
       if ($data->num_rows() == 0)
       {
           $new_data = array(
               'SyId' => $SyId,
               'SemId' => $SemId,
               'StudNo' => $StudNo,
               'time_start' => $time_start,
               'time_end' => date('Y-m-d H:i:s'),
               'User' => $this->session->userdata('session')['user_info']['Fname'] . ' ' . $this->session->userdata('session')['user_info']['Mname'] . ' ' . $this->session->userdata('session')['user_info']['Lname']
           );
           $this->db->insert('tblassessmentiso', $new_data);
       }
       else
       {
           $new_data = array(
               'time_end' => date('Y-m-d H:i:s'),
               'User' => $this->session->userdata('session')['user_info']['Fname'] . ' ' . $this->session->userdata('session')['user_info']['Mname'] . ' ' . $this->session->userdata('session')['user_info']['Lname']
           );

           $this->db->where($condition)->limit(1)->update('tblassessmentiso', $new_data);
       }

       $assess_data = array(
           'IsAssessed' => 1,
           'AssessedDateTime' => date('Y-m-d H:i:s')
       );
       $this->db->where($condition)->limit(1)->update('tblenrollmenttrans', $assess_data);


       // $this->db->close();

    }



    function getTuitionFee($StudNo)
    {
        $residency = $this->getResidency($StudNo);  # adjustment only owned voters are allowed for online assessment
        // $ownedvoter = $this->getVotersCertificate($StudNo);
        $hsu_grad = $this->get_hsu_grad($StudNo);

        # Fetch student assessment
        $this->db->select('A.*, B.*');
        $this->db->from('tblassessmentinfo as A');
        $this->db->join('tblfees as B','A.FeeId = B.FeeId','inner');

        # only students who owned voters allowed to be assessed


        $AssId = 5;                         # Non-Makati Tuition Fee
        if ($residency == '1') $AssId = 2;  # Makati Tuition Fee

        //-------------------------------------------HSU Graduate First Year


        if ($hsu_grad > 0) $AssId = 2;
        //-------------------------------------------

        $this->db->where('A.AssId', $AssId);
        /*
        if ( $ownedvoter == TRUE )
        {
            $this->db->where('A.AssId',2);
        }
        */

        $query = $this->db->get();

        $row = array();
        if($query->num_rows() > 0)
        $row = $query->result_array();

        // $this->db->close();
        return $row;
    }

    function getVotersCertificate($StudNo)
    {
        $this->db->from('tblstudinfo');
        $this->db->where('StudNo',$StudNo);
        $voters = $this->db->get();

        // $this->db->close();

        return $voters->row()->VotersCertificate == 1 ? TRUE : FALSE;
    }

    function getStudentAssessment($StudNo, $single = FALSE, $SySem = NULL, $SyId = NULL)
    {
        // Fetch assessment
        $this->db->select('C.*');
        $this->db->from('tblassessmenttrans as A');
        $this->db->join('tblassessmentinfo as B','A.AssId = B.AssId');
        $this->db->join('tblfees as C','C.FeeId = B.FeeId');
        $this->db->order_by('FundTypeId, FeeDesc');

        $SySem !== NULL ? $this->db->where('A.SemId', $SySem) : $this->db->where('A.SemId', $_SESSION['session']['sy_sem']['SemId']);
        $SyId  !== NULL ? $this->db->where('A.SyId', $SyId) : $this->db->where('A.SyId', $_SESSION['session']['sy_sem']['SyId']);


        $this->db->where('A.StudNo', $StudNo);

        $method = $single ? 'row_array' : 'result_array';

        return $this->db->get()->$method();
    }

    function getStudentPayment($StudNo, $single = FALSE, $SySem = NULL, $SyId = NULL)
    {
        // Fetch assessment
        $this->db->select('FeeDesc, A.*');
        // $this->db->from('tblassessmenttrans as A');
        // $this->db->join('tblassessmentinfo as B','A.AssId = B.AssId');
        $this->db->from('tblpaymentmisc as A');
        $this->db->join('tblfees as C','C.FeeId = A.FeeId', 'LEFT');

        $SySem !== NULL ? $this->db->where('A.SemId', $SySem) : $this->db->where('A.SemId', $_SESSION['session']['sy_sem']['SemId']);
        $SyId  !== NULL ? $this->db->where('A.SyId', $SyId) : $this->db->where('A.SyId', $_SESSION['session']['sy_sem']['SyId']);


        $this->db->where('A.StudNo', $StudNo);

        $method = $single ? 'row_array' : 'result_array';

        return $this->db->get()->$method();
    }



    function get_landbank_referrence($StudNo, $SemId, $SyId)
    {
        $conditions = array(
            'SemId' => $SemId,
            'SyId' => $SyId,
            'StudNo' => $StudNo,
            'actived' => 1
        );

        return $this->db->where($conditions)->get('tbllandbank')->row();
    }

    function landbank_referrence($StudNo, $SemId, $SyId)
    {

        # set timestamps
        $now = date('Y-m-d H:i:s');
        $ref_num = $this->get_landbank_referrence($StudNo, $SemId, $SyId);
        $conditions = array('SemId' => $SemId, 'SyId' => $SyId, 'StudNo' => $StudNo);

        $data = array(
            'StudNo' => $StudNo,
            'SemId' => $SemId,
            'SyId' => $SyId,
            'landbank_acct' => $this->input->post('methodpayment'),
            'created_at' => $now
        );

        if (count($ref_num) > 0)
        {
            # set actived to 0
            $this->db->where($conditions)->update('tbllandbank', array('actived' => 0));
            $data['created_at'] = $ref_num->created_at;
            $data['updated_at'] = date('Y-m-d H:i:s');

            $this->db->flush_cache();
        }

        # save
        $this->db->set($data);
        $this->db->insert('tbllandbank');
        $id = $this->db->insert_id();

        $this->db->flush_cache();

        # update assessmenttrans
        $this->db->where($conditions)->update('tblassessmenttrans', array('landbank_id' => $id));
        $this->db->flush_cache();

        return $id;
    }

     function AssessStudent($StudNo, $SemId, $SyId, $CollegeId, $ProgramId, $MajorId, $data1 = NULL, $data2 = NULL, $data3 = NULL, $data4 = NULL, $data5 = NULL)
    {
        $this->db->from('tblassessmenttrans as A');
        $this->db->where('SyId',$SyId);
        $this->db->where('SemId',$SemId);
        $this->db->where('StudNo',$StudNo);

        $query = $this->db->get();

        if($query->num_rows() > 0)
        {
            $this->db->where('SyId', $SyId);
            $this->db->where('SemId', $SemId);
            $this->db->where('StudNo', $StudNo);
            $this->db->delete('tblassessmenttrans');
        }

        //$data3 = $this->getScholarship($StudNo);

        /**
         * Fetch assessment per categories
         * @param: $StudNo, $CollegeId,$ProgramId,$MajorId
         **/
        // unset org Fee
        $unsetOrgFee= $this->getUnsetOrgFee($StudNo);
        if ($data1 === NULL)
        $data1 = $this->getStudentOrg($StudNo, $CollegeId, $ProgramId, $MajorId);

        if ($data2 === NULL)
        $data2 = $this->getAssPerSubject($StudNo);

        if ($data3 === NULL)
        $data3 = $this->getNSTPFEE($StudNo);
        // $data3 = array();

        if ($data5 === NULL)
        $data5 = $this->getLabFee($StudNo);

        if ($data4 === NULL)
        $data4 = $this->getTuitionFee($StudNo);

        // Fetch University ID Fee
        $dataID = array();
        if ($_SESSION['session']['sy_sem']['SemId'] == '1')
        {
            $dataID = $this->getIDFee($StudNo);
        }

        // Process assessment
        if (count($unsetOrgFee))
        {
            foreach ($data1 as $data1key => $data1Fees)
            {
                #check if has duplicate feeId
                $key_found = array_search($data1Fees['FeeId'], array_column_manual($unsetOrgFee, 'FeeId'));
                // dump($key_found);
                if ($key_found !== FALSE)
                    unset($data1[$data1key]);
            }
        }

        $data = array();
        foreach($data1 as $assess) {
            $data = array(
                'AssId' => $assess['AssId'],
                'SyId' => $SyId ,
                'SemId' => $SemId ,
                'StudNo' => $StudNo
            );
            $this->db->insert('tblassessmenttrans', $data);
        }

        $data = array();

        foreach ($data2 as $data2key => $data2Fees)
        {
            #check if has duplicate feeId
            $key_found = array_search($data2Fees['FeeId'], array_column_manual($data1, 'FeeId'));
            if ($key_found !== FALSE)
            unset($data2[$data2key]);
        }

        foreach($data2 as $assess) {
            $data = array(
                'AssId' => $assess['AssId'] ,
                'SyId' => $SyId ,
                'SemId' => $SemId ,
                'StudNo' => $StudNo
            );
            $this->db->insert('tblassessmenttrans', $data);
        }

        $data = array();
        foreach($data3 as $assess) {
            $data = array(
                'AssId' => $assess['AssId'] ,
                'SyId' => $SyId ,
                'SemId' => $SemId ,
                'StudNo' => $StudNo
            );
            $this->db->insert('tblassessmenttrans', $data);
            break;
        }
        // echo $this->db->last_query();

        $data = array();
        foreach($data5 as $assess) {
            $data = array(
                'AssId' => $assess['AssId'] ,
                'SyId' => $SyId ,
                'SemId' => $SemId ,
                'StudNo' => $StudNo
            );
            $this->db->insert('tblassessmenttrans', $data);

        }

        // DO NOT assess coahs students -- 06-04-2015 02:02 PM
        if ($CollegeId != 6)
        {
            $data = array();
            foreach($data4 as $assess) {
                $data = array(
                    'AssId' => $assess['AssId'] ,
                    'SyId' => $SyId ,
                    'SemId' => $SemId ,
                    'StudNo' => $StudNo
                );
                $this->db->insert('tblassessmenttrans', $data);
            }
        }


        // remove University ID Fee
        $data = array();
        foreach($dataID as $assess) {
            $data = array(
                'AssId' => $assess['AssId'] ,
                'SyId' => $SyId ,
                'SemId' => $SemId ,
                'StudNo' => $StudNo
            );
            $this->db->insert('tblassessmenttrans', $data);
        }
        // $this->db->close();

    }

     function isAssessIdExist($StudNo,$SyId,$SemId,$AssessId)
    {
        $this->db->select('A.FeeId');
        $this->db->where('StudNo', $StudNo);
        $this->db->where('SyId', $SyId);
        $this->db->where('SemId', $SemId);
        $this->db->where('A.AssId', $AssessId);
        $this->db->join('tblassessmentinfo as A','A.AssId = B.AssId', 'left');

        return FALSE;
    }

    function isStudentAssessed($StudNo,$SyId,$SemId)
    {

        $assessment = self::getStudentAssessment($StudNo, TRUE, $SemId, $SyId);
        if ( ! count($assessment))
        {
            // Process assessment
            $this->M_assessment->AssessStudent($StudNo, $SemId, $SyId,
                $this->session->userdata('session')['student_curriculum']['CollegeId'],
                $this->session->userdata('session')['student_curriculum']['ProgramId'],
                $this->session->userdata('session')['student_curriculum']['MajorId']
            );

            $this->load->model('M_enroll');
            $this->M_enroll->update_enrollment_trans($this->session->userdata('session')['enrollment_trans']['Id'],0,1);
        }

        if ( ! empty($this->session->userdata('session')['enrollment_trans']['Id']))
        {
            if ($this->session->userdata('session')['enrollment_trans']['IsAssessed'] != 1)
            {
                $this->load->model('M_enroll');
                $this->M_enroll->update_enrollment_trans($this->session->userdata('session')['enrollment_trans']['Id'],0,1);
            }
        }

        // if reached here student already assessed then return TRUE
        return TRUE;

        // $this->db->where(array('StudNo' => $StudNo, 'SyId' => $SyId, 'SemId' => $SemId));
        // $enrollment_trans = $this->db->get('tblenrollmenttrans')->row_array();

        // $this->db->close();

        // if ( ! empty($enrollment_trans))
        //     if ($enrollment_trans['IsAssessed'] == '1')
        //         return TRUE;

        // return FALSE;
    }

    /**
     * Identify weather the student is a makati / non-makati
     * by using student birthday and voters certification
     * @param: StudNo
     * @return: int
     **/

    function getResidency($StudNo)
    {
        // if($this->ageCalculator($StudNo) == 18 AND $this->isAccountingVerified($StudNo) == FALSE)
        // {
        //     return FALSE;
        // }

        // if it get here then student is a makati residence
        // return TRUE


        // $this->db->select('IsMakatiResident, VotersCertificate, LengthOfStayBySem');
        // $student = $this->db->where('StudNo',$StudNo)->get('tblstudinfo')->row();
        // $this->db->close();
        $student = $this->session->userdata('session')['student_info'];
        if ( ! empty($student))
        {
            $yr_level = $this->M_enroll->get_year_level($this->session->userdata('session')['student_curriculum']['CurriculumId'],
                $this->session->userdata('session')['student_curriculum']['CollegeId'],
                $student['LengthOfStayBySem']);

            // if ($_SESSION['session']['sy_sem']['SemId'] == 2 && in_array($student->LengthOfStayBySem, array(1, 2)))    # 1st Year 1st Sem, 1st Year 2nd Sem.
            // if ($_SESSION['session']['sy_sem']['SemId'] == 2 && $yr_level == 'First Year')    # 1st Year 1st Sem, 1st Year 2nd Sem.
            if ($_SESSION['session']['sy_sem']['SemId'] == 1 && $yr_level == 'Second Year')    # 1st Year 1st Sem, 1st Year 2nd Sem.
            {

                if ($student['IsMakatiResident'] == 1)
                {
                    // update RESIDENCY & VOTERS to 0
                    $this->db->limit(1);
                    $this->db->where('StudNo', $StudNo);
                    $this->db->update('tblstudinfo', array('IsMakatiResident' => 0, 'VotersCertificate' => 0));
                    // $this->db->close();

                    // $this->M_enroll->set_user_logs('First Year Student Set Residency to Non-Makati');
                    $this->M_enroll->set_user_logs('Second Year Student Set Residency to Non-Makati');

                    return 0;
                }
                // else
                // {
                //     $this->M_enroll->set_user_logs('Second Year Student NO Changes in Residency Makati');
                // }
            }


            if ($_SESSION['session']['sy_sem']['SemId'] == 2 && $yr_level == 'First Year')
            {
                $ASSID_MKT = 2;
                $ASSID_NONMKT = 5;

                $this->db->limit(1);
                $this->db->where([
                                    'StudNo' => $StudNo,
                                    'SyId' => $_SESSION['session']['sy_sem']['SyId'],
                                    'SemId' => $_SESSION['session']['sy_sem']['SemId']
                                ]);
                $this->db->where_in('AssId', [$ASSID_MKT, $ASSID_NONMKT]);
                $row = $this->db->get('tblassessmenttrans')->row();
                if (count($row))
                {
                    $this->M_enroll->set_user_logs('First Year Student Residency is Non-Makati make assessment same to 1st Sem Assessment');
                    if ($row->AssId == $ASSID_MKT)
                    {
                        return 1;
                    }
                    return 0;
                }

            }

            return $student['IsMakatiResident'];

        }

        return 0;
    }

    function isAccountingVerified($StudNo)
    {
        $where = array(
            'StudNo' => $StudNo,
            'SemId' => $_SESSION['session']['sy_sem']['SemId'],
            'SyId' => $_SESSION['session']['sy_sem']['SyId']
        );

        return $this->db->limit(1)->where($where)->get('tblverifiedmakati')->num_rows() > 0 ? TRUE : FALSE;
    }

     function ageCalculator($StudNo)
    {
        $AgeToday = $this->db->query('SELECT (YEAR(CURDATE())-YEAR(BirthDay)) - (RIGHT(CURDATE(),5) < RIGHT(BirthDay,5)) as AgeToday FROM tblstudinfo WHERE StudNo = "'.$StudNo.'" LIMIT 1')->row()->AgeToday;
        // echo $this->db->last_query();
        // $this->db->close();
        return $AgeToday;
    }

    function get_paymentMode($StudNo)
    {
        $this->db->where('StudNo',$StudNo);
        $this->db->where('SemId',$_SESSION['session']['sy_sem']['SemId']);
        $this->db->where('SyId',$_SESSION['session']['sy_sem']['SyId']);
        $paymode = $this->db->get('tblpaymentmode')->row_array();

        // $this->db->close();

        return $paymode;
    }

    function getAssessment($StudNo,$SyId,$SemId,$UserType)
    {
        $this->db->select('A.StudNo, A.AssId');
        $this->db->from('tblassessmentTrans as A');
        $this->db->where('SyId', $SyId);
        $this->db->where('SemId', $SemId);
        $this->db->where('A.StudNo',$StudNo);

        $query = $this->db->get();
        // $this->db->close();

        if($query->num_rows() > 0) {
                    $this->db->select('C.*');
                    $this->db->from('tblassessmenttrans as A');
                    $this->db->join('tblassessmentinfo as B','A.AssId = B.AssId');
                    $this->db->join('tblfees as C','C.FeeId = B.FeeId');
                    $this->db->where('A.SyId', $SyId);
                    $this->db->where('A.SemId', $SemId);
                    $this->db->where('A.StudNo',$StudNo);
            switch(true){
                case $UserType == 'C':  // cash

                    $where = '(C.FeeId = 20 OR C.FeeId = 21 OR C.FeeId = 16)';
                    $this->db->where($where);
                    $data = $this->db->get();
                    $row = $data->result_array();
                    return $row;
                    break;
                case $UserType == 'O':  // student organization

                    $where = 'NOT(C.FeeId = 20 OR C.FeeId = 21 OR C.FeeId = 16)';
                    $this->db->where($where);
                    $data = $this->db->get();
                    $row = $data->result_array();
                    return $row;
                    break;
                default :
                    return "Unauthorize Access!";
                    break;
            }

        }
    }

    function getTable2($TableName,$Field,$KeyCode,$Where='')
    {
        $this->db->select('A.*');
        $this->db->from( $TableName . ' as A');
        $this->db->where('A.'.$Field ,$KeyCode);

        if($Where)
        $this->db->where($Where);

        $query = $this->db->get();
        $row = array();
        if($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        // $this->db->close();
        return $row;
    }


    function getTable($TableName,$Field,$KeyCode,$Where='')
    {
        $this->db->select('A.*');
        $this->db->from( $TableName . ' as A');
        $this->db->where('A.'.$Field ,$KeyCode);
        if($Where)
        $this->db->where($Where);

        $query = $this->db->get();
        $data = $query->row();
        // $this->db->close();

        return $data;
    }

    function CountTfPayment($StudNo)
    {
        $sql = 'SELECT A.* FROM  `tblpaymenttrans` as A
                    WHERE StudNo =  "'.$StudNo.'" AND
                            SyId = "'.$this->session->userdata('session')['SyId'].'" AND
                            SemId = "'.$this->session->userdata('session')['SemId'].'" AND
                            ( FeeId = 20 OR FeeId = 21)';
        $query = $this->db->query($sql);
        // $this->db->close();
        return $query;
    }

    function totalTFPayment($StudNo)
    {
        $sql = 'SELECT SUM( AmountPaid ) AS AmountPaid, StudNo FROM  `tblpaymenttrans`
                    WHERE StudNo =  "'.$StudNo.'" AND
                        SyId = "'.$this->session->userdata('session')['SyId'].'" AND
                        SemId = "'.$this->session->userdata('session')['SemId'].'" AND
                        ( FeeId = 20 OR FeeId = 21 )
                    GROUP BY StudNo, SyId, SemId';
        $query = $this->db->query($sql);
        $data = $query->row();
        // $this->db->close();
        return $data;
    }

    function getSem($SemId)
    {
        $this->db->select('A.*');
        $this->db->from('tblsem as A');
        $this->db->where('A.SemId',$SemId);

        $query = $this->db->get();
        $data = $query->row();
        // $this->db->close();

        return $data;
    }

    function getSy($SyId)
    {
        $this->db->select('A.*');
        $this->db->from('tblsy as A');
        $this->db->where('A.SyId',$SyId);

        $query = $this->db->get();
        $data = $query->row();
        // $this->db->close();

        return $data;
    }

     function getOR($OrNum)
    {
        $this->db->select('A.*');
        $this->db->from('tblpaymenttrans as A');
        $this->db->where('A.OrNo',$OrNum);

        $query = $this->db->get();
        // $this->db->close();

        if($query->num_rows() > 0) {
            return true;
        }

    }

      function getAllScholarship()
    {
        $query = $this->db->order_by('DiscountPercentage, ScholarshipDesc')->get('tblscholarship');
        return $query->result_array();
    }

     function getFee($FeeId)
    {
        $this->db->select('A.*');
        $this->db->from('tblfees as A');
        $this->db->where('A.FeeId',$FeeId);

        $query = $this->db->get();
        $data = $query->row();
        // $this->db->close();

        return $data;
    }

     function getPayment($OrNum,$table)
    {
        $this->db->select('A.*');
        $this->db->from($table . ' as A');
        $this->db->where('A.OrNo',$OrNum);

        $query = $this->db->get();
        $data = $query->result_array();
        // $this->db->close();

        return $data;
    }

    function sum_tokenfee_payment($StudNo, $SyId, $SemId)
    {
        $data = array();
        $this->db->select_sum('Amount');
        $this->db->where_in('feeid', array('20', '21', '47'));
        $this->db->where('is_actived', 1);
        $this->db->where('StudNo', $StudNo)->where('SyId', $SyId)->where('SemId', $SemId);
        $data = $this->db->get('tblpayment')->row_array();
        // $this->db->close();

        return $data;
    }

    function sum_miscfee_payment($StudNo, $SyId, $SemId)
    {
        $data = array();
        $this->db->select_sum('Amount');
        $this->db->where('StudNo', $StudNo)->where('SyId', $SyId)->where('SemId', $SemId);
        $data = $this->db->get('tblpaymentmisc')->row_array();
        // $this->db->close();

        return $data;
    }

    public function sum_billing_payment($bill_id = NULL, $single = TRUE)
    {
        $this->db->select('
                            C.FeeId,
                            FeeDesc,
                            SUM(bill_detail_amount) as Amount,
                            amount_due,
                            (
                                SELECT IFNULL(SUM(bill_scan_value), 0) FROM tblbill_scan2pay
                                WHERE bill_scan_bill_id = bill_id
                                      AND bill_scan_is_active = 1
                                      AND bill_scan_fieldname = "amount_you_pay"
                            ) as bill_paid_amount,
                            (
                                SELECT GROUP_CONCAT(
                                    DISTINCT concat(bill_scan_fieldname, ": ", bill_scan_value)
                                    ORDER BY bill_scan_fieldname, bill_scan_created_at
                                    SEPARATOR ";"
                                ) FROM tblbill_scan2pay
                                WHERE bill_scan_bill_id = bill_id
                                    AND bill_scan_is_active = 1
                            ) as ornum
                         ');
        $this->db->join('tblbilling_detail as B','B.bill_detail_bill_id = A.bill_id','left')
                 ->join('tblfees as C','C.FeeId  = B.bill_detail_fee_id','left')
                 ->join('tblsy as D','D.SyDesc  = A.acad_year', 'left')
                 ->join('tblsem as E','E.SemId  = A.sem_id','left')
                 ->order_by('FundTypeId')
                 // ->having('amount_due != bill_paid_amount', NULL, FALSE)
                 ->group_by('C.FeeId');


        $bill_id && $this->db->where('bill_id', $bill_id);
        $this->db->where('bill_is_active', 1);


        $method = intval($bill_id) || $single ? 'row_array' : 'result_array';



        return $this->db->get('tblbilling as A')->$method();
    }


    public function sum_billing_payment_by($where, $single = FALSE)
    {
        $this->db->where($where);

        return self::sum_billing_payment(NULL, $single);
    }

    public function get_cash_payment($id = NULL, $single = TRUE)
    {
        $method = intval($id) || $single ? 'row_array' : 'result_array';

        $id && $this->db->where('PaymentId', $id);
        $this->db->where('is_actived', 1);

        $this->db->select('A.*, B.FeeDesc, B.Amount as Assessment');
        $this->db->join('tblfees as B', 'A.FeeId = B.FeeId', 'left');

        return $this->db->get('tblpayment as A')->$method();
    }

    public function get_cash_coahs_payment($id = NULL, $single = TRUE)
    {
        $method = intval($id) || $single ? 'row_array' : 'result_array';

        $id && $this->db->where('PaymentId', $id);
        $this->db->where('is_actived', 1);

        $this->db->select('A.*, B.FeeDesc, B.Amount as Assessment');
        $this->db->join('tblfees as B', 'A.FeeId = B.FeeId', 'left');

        return $this->db->get('tblpayment_coahs as A')->$method();
    }

    public function get_misc_payment($id = NULL, $single = TRUE)
    {
        $method = intval($id) || $single ? 'row_array' : 'result_array';

        $id && $this->db->where('PaymentId', $id);
        $this->db->where('is_actived', 1);

        $this->db->select('A.*, B.FeeDesc, B.Amount as Assessment');
        $this->db->join('tblfees as B', 'A.FeeId = B.FeeId', 'left');

        return $this->db->get('tblpaymentmisc as A')->$method();
    }

    public function get_misc_payment_by($where, $single = FALSE)
    {
        $this->db->where($where);
        return self::get_misc_payment(NULL, $single);
    }

    public function get_cash_payment_by($where, $single = FALSE)
    {
        $this->db->where($where);
        $data = self::get_cash_payment(NULL, $single);

        if (empty($data))
        {
            $this->db->where($where);
            $data = self::get_cash_coahs_payment(NULL, $single);
        }

        return $data;
    }

    public function get_billing_details($bill_id)
    {
        # code...
    }

    function get_tokenfee_payment($StudNo, $SyId, $SemId)
    {
        $this->db->select('bill_detail_amount as Assessment,bill_detail_amount as Amount,bill_trans_date as Date,bill_paid_thru as User,bill_trans_no as ornum');
        $this->db->join('tblbilling_detail as B','B.bill_detail_bill_id = A.bill_id','left')
                 ->join('tblfees as C','C.FeeId  = B.bill_detail_fee_id','left')
                 ->join('tblsy as D','D.SyDesc  = A.acad_year')
                 ->join('tblsem as E','E.SemId  = A.sem_id','left');

        $this->db->where('SyId',$SyId);
        $this->db->where('SemId',$SemId);
        $this->db->where('student_id',$StudNo);
        $this->db->where('bill_trans_date > 0');
        $this->db->where('bill_is_active',1);

        $this->db->where_in('C.FeeId', array('20', '21', '47'));

        $billing = $this->db->get('tblbilling as A')->result_array();

        if (!empty($billing))
        {
            return $billing;
        }
        else
        {

            $data = array();
            $this->db->select('A.*, B.FeeDesc, B.Amount as Assessment');
            $this->db->where('StudNo', $StudNo)->where('SyId', $SyId)->where('SemId', $SemId)->where_in('A.FeeId', array('20', '21', '47'));
            $this->db->join('tblfees as B', 'A.FeeId = B.FeeId', 'left');
            $data = $this->db->get('tblpayment as A')->result_array();

            if (empty($data)) {
                $data = array();
                $this->db->select('A.*, B.FeeDesc, B.Amount as Assessment');
                $this->db->where('StudNo', $StudNo)->where('SyId', $SyId)->where('SemId', $SemId)->where('A.FeeId', 47);
                $this->db->join('tblfees as B', 'A.FeeId = B.FeeId', 'left');
                $data = $this->db->get('tblpayment_coahs as A')->result_array();
            }
            // $this->db->close();

            return $data;
        }
    }

    function get_id_payment($StudNo, $SyId, $SemId,$single = TRUE)
    {

        $this->db->select('bill_detail_amount as Assessment,bill_detail_amount as Amount,bill_trans_date as Date,bill_paid_thru as User,bill_trans_no as ornum,bill_detail_fee_id as FeeId');
        $this->db->join('tblbilling_detail as B','B.bill_detail_bill_id = A.bill_id','left')
                 ->join('tblfees as C','C.FeeId  = B.bill_detail_fee_id','left')
                 ->join('tblsy as D','D.SyDesc  = A.acad_year')
                 ->join('tblsem as E','E.SemId  = A.sem_id','left');

        $this->db->where('SyId',$SyId);
        $this->db->where('SemId',$SemId);
        $this->db->where('student_id',$StudNo);
        $this->db->where('bill_trans_date > 0');
        $this->db->where('bill_is_active',1);

        $this->db->where_in('C.FeeId', array('37'));

        if ($single)
            $billing = $this->db->get('tblbilling as A')->row_array();
        else
            $billing = $this->db->get('tblbilling as A')->result_array();


        if (!empty($billing))
        {
            return $billing;
        }
        else
        {

            $data = array();
            $this->db->select('A.*, B.FeeDesc, B.Amount as Assessment');
            $this->db->where('is_actived',1);
            $this->db->where('StudNo', $StudNo)->where('SyId', $SyId)->where('SemId', $SemId)->where_in('A.FeeId', array(37));
            $this->db->join('tblfees as B', 'A.FeeId = B.FeeId', 'left');
            $data = $this->db->get('tblpayment as A')->row_array();
            // $this->db->close();

            if (!empty($data))
                return $data;
            else
                return $data = array('Amount' => 0);

        }

    }


    function get_miscfee_payment($StudNo, $SyId, $SemId )
    {
        $this->db->select('bill_detail_amount as Assessment,bill_detail_amount as Amount,bill_trans_date as Date,bill_paid_thru as User,bill_trans_no as ornum,,bill_detail_fee_id as FeeId');
        $this->db->join('tblbilling_detail as B','B.bill_detail_bill_id = A.bill_id','left')
                 ->join('tblfees as C','C.FeeId  = B.bill_detail_fee_id','left')
                 ->join('tblsy as D','D.SyDesc  = A.acad_year')
                 ->join('tblsem as E','E.SemId  = A.sem_id','left');

        $this->db->where('SyId',$SyId);
        $this->db->where('SemId',$SemId);
        $this->db->where('student_id',$StudNo);
        $this->db->where('bill_trans_date > 0');
        $this->db->where('bill_is_active',1);

        $this->db->where_not_in('C.FeeId', array('20', '21', '47','51','37'));

        $billing = $this->db->get('tblbilling as A')->result_array();

        if (!empty($billing))
        {
            return $billing;
        }
        else
        {

            $data = array();

            $this->db->select('A.*, B.FeeDesc, B.Amount as Assessment');
            $this->db->where('StudNo', $StudNo)->where('SyId', $SyId)->where('SemId', $SemId);
            $this->db->join('tblfees as B', 'A.FeeId = B.FeeId', 'left');
            $data = $this->db->get('tblpaymentmisc as A')->result_array();
            // $this->db->close();

            return $data;
        }
    }

     function payment1($StudNo,$SemId,$SyId,$UserName)
    {
        $Nstp = $this->getFee(16);
        $NstpFee = $Nstp->Amount;
        // $this->db->close();

        $User = $this->getTable('tbladminaccount','Username',$UserName);
        $CashUser = $User ? $User->AdminId : ' ';

        $date_now = date('Y-m-d H:i:s',time());

        $Scholarship = $this->getScholarship($StudNo);
        $discount = $Scholarship ? $Scholarship->DiscountPercentage : '0.00' ;
        $data = $this->input->post('fee');

            foreach($data as $field => $value) {
                $this->db->select('A.*');
                $this->db->from('tblfees as A');
                $this->db->where('A.FeeId',$value);
                $row = $this->db->get();
                $tblFees = $row->row();

                if($value == 16) {
                    $amount = $tblFees->Amount;
                } else {
                    if($this->input->post('txtPayable') >= $this->input->post('txtAmount') ) {
                        $amount = ($this->input->post('txtAmount') - ( count($data) > 1 ? $NstpFee : 0.00 ) );
                    } else {
                        if($value == 20 || $value == 21) {
                            if($this->input->post('txtAmount') >= $tblFees->Amount)
                                $amount = $tblFees->Amount - ($tblFees->Amount * $discount);
                            else
                                $amount = ($this->input->post('txtPayable') - ( count($data) > 1 ? $NstpFee : 0.00 ) );
                        } else {
                            $amount = $tblFees->Amount;
                        }
                    }
                }

                $data2 = array(
                    'StudNo' => $StudNo,
                    'AmountPaid' => $amount ,
                    'Officer' => $CashUser ,
                    'FeeId' => $tblFees->FeeId,
                    'BookletNo' => $this->input->post('txtBooklet'),
                    'OrNo' => $this->input->post('txtOrNum'),
                    'SyId' => $SyId,
                    'SemId' => $SemId
                );
                $this->db->insert('tblpaymenttrans', $data2);
                $this->db->where('StudNo',$StudNo);
                $this->db->where('SyId',$SyId);
                $this->db->where('SemId',$SemId);
                $data2 = array(
                    $value == 16 ? 'PaidNSTPDateTimeStart' : 'PaidTokenDateTimeStart' => $date_now
                );
                $this->db->update('tblenrollmenttrans',$data2);
                // $this->db->close();
            }
    }

     function payment2($StudNo,$SemId,$SyId,$UserName)
    {
        $data = $this->input->post('fee');
        $User = $this->getTable('tbladminaccount','Username',$UserName);
        $CashUser = $User ? $User->AdminId : ' ';
        $date_now = date('Y-m-d H:i:s',time());
            foreach($data as $field => $value) {
                $this->db->select('A.*');
                $this->db->from('tblFees as A');
                $this->db->where('A.FeeId',$value);
                $row = $this->db->get();
                $tblFees = $row->row();

                $data2 = array(
                    'StudNo' => $StudNo,
                    'AmountPaid' => $tblFees->Amount,
                    'Officer' => $CashUser ,
                    'FeeId' => $tblFees->FeeId,
                    'BookletNo' => $this->input->post('txtBooklet'),
                    'OrNo' => $this->input->post('txtOrNum'),
                    'SyId' => $SyId,
                    'SemId' => $SemId
                );
                $this->db->insert('tblpaymenttrans2', $data2);
                // $this->db->close();
            }
        $this->db->where('StudNo',$StudNo);
        $this->db->where('SyId',$SyId);
        $this->db->where('SemId',$SemId);
        $data2 = array(
                'PaidMiscDateTimeStart' => $date_now
        );
        $this->db->update('tblenrollmenttrans',$data2);
        // $this->db->close();
    }


    function get_hsu_grad($StudNo)
    {
        // $this->db->select('IsMakatiResident, VotersCertificate, LengthOfStayBySem');
        // $student = $this->db->where('StudNo',$StudNo)->get('tblstudinfo')->row();
        $student = $this->session->userdata('session')['student_info'];
        if ( ! empty($student))
        {
            $yr_level = $this->M_enroll->get_year_level($this->session->userdata('session')['student_curriculum']['CurriculumId'],
                $this->session->userdata('session')['student_curriculum']['CollegeId'],
                $student['LengthOfStayBySem']);

            if ($yr_level == 'First Year')
            {
                # Get Hsu Graduates
                //------------------------------------------------------------------------------------------------------------------
                $HsuGradSql = "Select count(stud_id) as cnt from  ". DBHSU ."student_enrollments
                               where sy_id = 9  and sem_id = 2 and is_actived = 1  and yr_level = 'GRADE 12' and stud_id = '{$StudNo}' ";

                $HsuGrad = $this->db->query($HsuGradSql)->row();
                // ------------------------------------------------------------------------------------------------------------------


                if ($HsuGrad->cnt > 0)
                {
                    $this->M_enroll->set_user_logs('HSU Graduate');

                    // $this->db->close();
                    return 1;
                }

                $this->M_enroll->set_user_logs('Non HSU Graduate');
                // return 0;
            }


            // $this->db->close();
            // return 0;

        }

        // $this->db->close();

        return 0;
    }

}
