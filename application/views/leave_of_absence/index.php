<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 completion-ct mt-3 print_hide" >
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
			<a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#apply_loa"><i class="fas fa-hand-point-up"></i> Apply Leave of Absence</a>
			<h4 class="letter-spacing-ct mt-3"><i class="fas fa-list-ul"></i> HISTORY OF FILING</h4>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th class="align-middle text-center" width="8%">Date of Filing</th>
							<th class="align-middle text-center" width="10%">Academic Year</th>
							<th class="align-middle text-center" width="10%">Semester</th>
							<!-- <th class="align-middle text-center" width="6%">One Year / One Sem</th> -->
							<th class="align-middle text-center" width="40%">Reason</th>
							<th class="align-middle text-center" width="13%">Guardian</th>
							<th class="align-middle text-center" width="13%">Staff</th>
							<th class="align-middle text-center" width="6%">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($stud_loa as $key => $row): ?>
							<tr>
								<td><?php echo proper_date($row->date_filed) ?></td>
								<td>
									<?php 
											if ($row->IsOneYear == 1)
											{
												if ($row->LoaStartSyId == $row->LoaEndSyId)
													echo $sy_loa[$row->LoaEndSyId]['Desc'];
												else
													echo $sy_loa[$row->LoaStartSyId]['Desc']." to ".$sy_loa[$row->LoaEndSyId]['Desc'];
											}
											
											if ($row->IsOneSem == 1)
												echo $sy_loa[$row->LoaEndSyId]['Desc'];
											
										?>
								</td>
								<td>
									<?php 
											if ($row->IsOneYear == 1)
												echo semDescConvert($row->LoaStartSemId)['Code'].", ".semDescConvert($row->LoaEndSemId)['Code'];
											
											if ($row->IsOneSem == 1)
												echo semDescConvert($row->LoaEndSemId)['Code'];
										?>
								</td>
							<!-- 	<td><?php 
											// if ($row->IsOneYear == 1)
											// 	echo "One Year";
											
											// if ($row->IsOneSem == 1)
											// 	echo "One Sem";

										?>
								</td> -->
								<td><?php echo $row->reason; ?></td>
								<td><?php echo $row->guardian; ?></td>
								<td><?php echo $staff[$row->user_id]['Fullname'] ?></td>
								<td class="text-center">
									<?php 
										$name = $student_info->Fname.' '.$student_info->Mname.' '.$student_info->Lname;
										$StudNo = $row->StudNo;
										$College = $student_info->CollegeCode;
										$Major = $student_info->MajorDesc;

										if ($Major == ' ' || $Major == NULL ) 
											$Program = $student_info->ProgramDesc;
										else
											$Program = $student_info->ProgramDesc.' MAJOR IN '.$student_info->MajorDesc;

											if ($row->IsOneYear == 1)
											{
												if ($row->LoaStartSyId == $row->LoaEndSyId)
													$acad_yr = $sy_loa[$row->LoaEndSyId]['Desc'];
												else
													$acad_yr = $sy_loa[$row->LoaStartSyId]['Desc']." to ".$sy_loa[$row->LoaEndSyId]['Desc'];
											}
											
											if ($row->IsOneSem == 1)
											{
												$acad_yr = $sy_loa[$row->LoaEndSyId]['Desc'];
											}
											

											if ($row->IsOneYear == 1)
											{
												$semester= semDescConvert($row->LoaStartSemId)['Code'].", ".semDescConvert($row->LoaEndSemId)['Code'];
											}
											
											if ($row->IsOneSem == 1)
											{
												$semester= semDescConvert($row->LoaEndSemId)['Code'];
											}

										
										$reason = $row->reason;
										$guardian = $row->guardian;
										$dean = $dean[$student_info->CollegeId]['dean_name'];
										$staff = $staff[$row->user_id]['Fullname'];

									 ?>

									<!-- <a href="<?php // echo base_url('leave_of_absence/view_loa/').$row->stud_loa_id ?>" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a> -->
									<!-- <a href="<?php //echo base_url('leave_of_absence/print_loa/').$row->stud_loa_id ?>" class="btn btn-secondary btn-sm"><i class="fas fa-print"></i> Print</a> -->
									<button type="button"class="btn btn-secondary btn-sm"
										data-name = "<?php echo $name;?>"
										data-studno = "<?php echo $StudNo;?>"
										data-college = "<?php echo $College;?>"
										data-program = "<?php echo $Program;?>"
										data-semester = "<?php echo $semester;?>"
										data-acad_yr = "<?php echo $acad_yr;?>"
										data-reason = "<?php echo $reason;?>"
										data-guardian = "<?php echo $guardian;?>"
										data-dean = "<?php echo $dean;?>"
										data-staff = "<?php echo $staff;?>"
										onclick="print_page(this)"
									><i class="fas fa-print"></i> Print</button>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				<?php // dump($student_info) ?>
				<?php // dump($stud_loa) ?>

			</div>
		</div>
	</div>
</div>

<?php $this->load->view('leave_of_absence/apply_loa'); ?>


<script type="text/javascript">
	function print_page(e) {
		// console.log(e.dataset)
		$("#loa_print #name").html(e.dataset.name);
		$("#loa_print #studno").html(e.dataset.studno);
		$("#loa_print #college").html(e.dataset.college);
		$("#loa_print #program").html(e.dataset.program);
		$("#loa_print #semester").html(e.dataset.semester);
		$("#loa_print #acad_yr").html(e.dataset.acad_yr);
		$("#loa_print #reason").html(e.dataset.reason);
		$("#loa_print #guardian").html(e.dataset.guardian);
		$("#loa_print #dean").html(e.dataset.dean);
		$("#loa_print #staff").html(e.dataset.staff);


    window.print();
    // const printContents = document.getElementById('loa_print').innerHTML;
    // const originalContents = document.body.innerHTML;
    // document.body.innerHTML = printContents;
    // document.body.innerHTML = originalContents;
	}
</script>

<script>
$(document).ready(function(){
    $("select").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".ot-div").not("." + optionValue).hide();
                $("." + optionValue).show();
            } else{
                $(".ot-div").hide();
            }
        });
    }).change();
});
</script>