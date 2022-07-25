<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">
    <title>UMak Student Information Management System</title>
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/print_custom.css" media="print">
  </head>

  <style type="text/css">
    .border-none, .border-none tr,.border-none td{
      border-style: none  !important;
      border: 0 !important;
    }

    body{
      font-size: 10.5pt !important;
    }

    .border-none>:not(caption)>*>* {
      padding: 0 !important;
    }

    .record-ct>:not(caption)>*>*{
      padding: 2px !important;
    }

    .record-ct{
      font-size: 8pt !important;
    }

    .table {
      margin-bottom: 2px;
    }

    .hide-ct, .title-hide, .info-hide{
      display: none;
    }

    .minh-ct{
      min-height: 376px;
    }

    .show-ct{
      display: inline;
    }

    .personal-information-ct{
      min-height: 233px !important;
    }

    .header-ct{
      min-height: 108.90px !important;
    }


  </style>
<body>
  <?php 

    $StudName = $student_info->Lname.', '.$student_info->Fname.' '.$student_info->Mname;
    $Gender = ($student_info->Gender = 'M') ? 'MALE' : 'FEMALE';
    $Address =  $student_info->AddressStreet.' '.$student_info->AddressBarangay.' '.$student_info->AddressCity;
    $College = ($student_info->CollegeCode != NULL) ? $student_info->CollegeCode : '';
    $Program = ($student_info->ProgramDesc != NULL) ? $student_info->ProgramDesc : '';
    $Major = ($student_info->MajorDesc != NULL) ? $student_info->MajorDesc : '';

    $Civil_Status ='';
    $Place_Birth ='';
    $Nationality ='';
    $Guardian_Relationship ='';
    $Guardian_Occupation ='';
    $Guardian_Address ='';
    $HSGraduated ='';
    $AddressSecondSchool ='';
    $DateGrad ='';
    $LastSchoolAttended ='';
    $InclusiveDate ='';

    $cntyr = 0;

   ?>
   <?php foreach ($student_grades as $key => $sgAy): ?>
   <?php 
    $cntyr++;
    endforeach;

    $shows = 'hide-ct';

    if ('ALL'== $this->uri->segment(4))
      $shows = "show-ct";



    ?>
  <div class="container-fluid">
      <div class="row header-ct">
          <div class="col-xs-12 text-center title-hide <?php echo $shows; ?> ">
            <h4 class="mb-0">UNIVERSITY OF MAKATI</h4>
            <p class="mb-0">J.P. Rizal Extension, West Rembo, Makati City</p>
            <h5>OFFICE OF THE REGISTRAR</h5>
          </div>
          <div class="col-xs-12 text-center title-hide <?php echo $shows; ?> ">
            <h6>Student's Permanent Record</h6>
          </div>
      </div>
      <div class="row personal-information-ct">
        <div class="col-xs-12 info-hide <?php echo $shows; ?> ">
          <table class="table border-none">
            <tr>
              <td width="8.33%"></td>
              <td width="8.33%"></td>
              <td width="8.33%"></td>
              <td width="8.33%"></td>
              <td width="8.33%"></td>
              <td width="8.33%"></td>
              <td width="8.33%"></td>
              <td width="8.33%"></td>
              <td width="8.33%"></td>
              <td width="8.33%"></td>
              <td width="8.33%"></td>
              <td width="8.33%"></td>
            </tr>
            <tr>
              <td colspan="2">Student I.D. No.:</td>
              <td colspan="10"><b><?php echo ($student_info->StudNo != NULL) ? $student_info->StudNo : ''; ?></b></td>
            </tr>
            <tr>
              <td colspan="1">College:</td>
              <td colspan="1"><b><?php echo $College;?></b></td>
              <td colspan="1">Program:</td>
              <td colspan="5"><b><?php echo $Program;?></b></td>
              <td colspan="1">Major:</td>
              <td colspan="3"><b><?php echo $Major?></b></td>
            </tr>
            <tr>
              <td colspan="1">Name:</td>
              <td colspan="11"><b><?php echo  $StudName;?></b></td>
            </tr>
            <tr>
              <td colspan="2">Home Address:</td>
              <td colspan="10"><b><?php echo $Address;?></b></td>
            </tr>
            <tr>
              <td colspan="2">Date of Birth:</td>
              <td colspan="2"><b><?php echo payroll_date($student_info->BirthDay);?></b></td>
              <td colspan="2">Place of Birth:</td>
              <td colspan="6"><b><?php echo $Place_Birth;?></b></td>
            </tr>
            <tr>
              <td colspan="1">Sex:</td>
              <td colspan="1"><b><?php echo $Gender;?></b></td>
              <td colspan="1">Tel. No.:</td>
              <td colspan="2"><b><?php echo ($student_info->Contact !='') ? $student_info->Contact : '';?></b></td>
              <td colspan="2">Nationality:</td>
              <td colspan="2"><b><?php echo $Nationality;?></b></td>
              <td colspan="2">Civil Status:</td>
              <td colspan="1"><b><?php echo $Civil_Status;?></b></td>
            </tr>
            <tr>
              <td colspan="3">Name of Patent/Guardian:</td>
              <td colspan="5"><b><?php echo ($student_info->Guardian !='') ? $student_info->Guardian : '';?></b></td>
              <td colspan="2">Relationship:</td>
              <td colspan="2"><b><?php echo $Guardian_Relationship;?></b></td>
            </tr>
            <tr>
              <td colspan="1">Occupation:</td>
              <td colspan="4"><b><?php echo $Guardian_Occupation;?></b></td>
              <td colspan="1">Address:</td>
              <td colspan="6"><b><?php echo $Guardian_Address;?></b></td>
            </tr>
            <tr>
              <td colspan="4">High School from which graduated:</td>
              <td colspan="8"><b><?php echo $HSGraduated;?></b></td>
            </tr>
            <tr>
              <td colspan="3">Address Secondary School:</td>
              <td colspan="5"><b><?php echo $AddressSecondSchool;?></b></td>
              <td colspan="2">Date Graduated:</td>
              <td colspan="2"><b><?php echo $DateGrad;?></b></td>
            </tr>
            <tr>
              <td colspan="3">Last Schools Attended:</td>
              <td colspan="5"><b><?php echo $LastSchoolAttended;?></td>
              <td colspan="2">Inclusive Date:</td>
              <td colspan="2"><b><?php echo $InclusiveDate;?></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="row grade-cy">
       <?php
          $sems = 0;
          $cntyr = 0;
        ?>
        <?php foreach ($student_grades as $key => $sgAy): ?>
          <?php 
            $cnt = 0;
            $cntyr++;
            $sems = 3 - count($sgAy);
            $syKey = $key;
          ?>
          <?php foreach ($sgAy as $sgSemKey => $sgSem): ?>
          <?php $cnt++; ?>
          <?php 
            $shows = 'hide-ct';
            $show = $syKey.'-'.$cnt;

            if ($show == $this->uri->segment(4))
              $shows = 'show-ct';
            elseif('ALL'== $this->uri->segment(4))
              $shows = "show-ct";
          ?>
            <div class="col-4 p-1 mb-3">
              <div class="row minh-ct">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 <?php echo $shows; ?>">
                  <div class="row" style="font-size: 9.5pt;">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">Semester : <b><u><?php echo $sgSemKey ?></u></b></div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-end">A.Y. : <b><u><?php echo $key ?></u></b></div>
                  </div>
                  <table class="table table-bordered record-ct">
                    <tr>
                      <th width="60%" class="align-middle text-center" width="">COURSES</th>
                      <th width="12%" class="align-middle text-center" width="">FINAL</th>
                      <th width="12%" class="align-middle text-center" width="">R'VAL</th>
                      <th width="12%" class="align-middle text-center" width="">LAB</th>
                      <th width="12%" class="align-middle text-center" width="">R'Val</th>
                      <th width="12%" class="align-middle text-center" width="">UNITS</th>
                    </tr>
                    <?php $td = 14 - count($sgSem) ?>
                    <?php foreach ($sgSem as $details => $sgDetails): ?>
                      <tr>
                        <td><?php echo $sgDetails['CourseCode']  ?></td>
                        <td><?php echo $sgDetails['StrGrade'] ?></td>
                        <td><?php echo $sgDetails['RVal'] ?></td>
                        <td><?php echo $sgDetails['StrLab'] ?></td>
                        <td><?php echo $sgDetails['RValLab'] ?></td>
                        <td><?php echo $sgDetails['units'] ?></td>
                      </tr>
                    <?php endforeach?>
                    <?php if ($td): ?>
                      <?php for ($i=1; $i <=$td ; $i++) : ?>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                      <?php endfor ?>
                    <?php endif ?>
                  </table>
                  <b style="font-size: 8pt !important"><?php echo $StudName; ?></b><br>
                  Prepared by:___________________________
                </div>
              </div>
            </div>
          <?php endforeach?> 

            <?php if ($sems): ?>
              <?php for ($i=1; $i <=$sems ; $i++) : ?>
                <div class="col-4 p-1 mb-3">
                </div>
              <?php endfor ?>
            <?php endif ?>   

            <?php if ($cntyr == 2) {
              echo "<div class='clear-fix'></div>";
              // echo "<div class='pagebreak'></div>";
              echo "<div class='col-12' style='margin-bottom:45px;'></div>";
            } ?>
        <?php endforeach?>      
      </div>
  </div>
</body>
</html>
