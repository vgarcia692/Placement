<div class="content hidden-print" id="containerid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        <h4 class="errorlabel"><?php if (isset($_SESSION['error'])) {echo $_SESSION['error'];} ?></h4>
        

        <legend>Exam: <?php echo $id; ?></legend>
        <div>
        <button type="button" id="printBtn" class="btn btn-default">Print English/Math Level</button>
        </div></br>

        <div>

          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#personal" aria-controls="personal" role="tab" data-toggle="tab">Personal</a></li>
            <li role="presentation"><a href="#examResults" aria-controls="examResults" role="tab" data-toggle="tab">Exam Results </a></li>
            <li role="presentation"><a href="#examDetails" aria-controls="examDetails" role="tab" data-toggle="tab">Exam Details</a></li>
            <li role="presentation"><a href="#admissionsRegistrations" aria-controls="admissionsRegistrations" role="tab" data-toggle="tab">Admissions/Registrations</a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="personal">
                <div style="margin: 5px;" class="well">
                    <label>Name:</label>
                    <p><?php echo $exam['f_name'].' '.$exam['m_initial'].$exam['l_name']; ?></p>
                    <label>Social Security Number:</label>
                    <p><?php echo $exam['ssn']; ?></p>
                    <label>Date of Birth:</label>
                    <p><?php echo $exam['dob']; ?></p>
                    <label>Gendr:</label>
                    <p><?php echo $exam['gender']; ?></p>
                    <label>High School:</label>
                    <p><?php echo $exam['high_school']; ?></p>
                    <form id="sisForm">
                    <div class="form-group">
                        <label for="sisName">SIS Full Name</label>
                        <input class="form-control" id="sisName" name="sisName" class="sisName" type="text" value="<?php echo $exam['sis_full_name']; ?>"></input>
                    </div>
                    <div class="form-group">
                        <label for="sisNumber">SIS Student Number</label>
                        <input class="form-control" id="sisNumber" name="sisNumber" class="sisNumber" type="text" value="<?php echo $exam['sis_stud_no']; ?>"></input>
                    </div>
                    <input hidden type="text" name="id" value="<?php echo $id; ?>"></input>
                    </form>

                    <button type="button" id="savePersonalInfo" class="btn btn-default">Save</button>

                </div>

            </div>
            <div role="tabpanel" class="tab-pane" id="examResults">
                <div style="margin: 5px;" class="well">
                    <label>Taken Exam Before:</label>
                    <input type="checkbox" <?php if($exam['taken_before']==true) {echo 'checked';} ?> id="tookExamChk" disabled ></input><br>
                    
                    <?php if($exam['taken_before']==true) { ?>  
                        <div id="didTakeBeforeDiv">
                            <label>If Taken Exam, When:</label>
                            <p><?php echo $exam['if_taken_when']; ?></p>
                        </div>
                    <?php } ?>
                    
                        
                    <label>Exam Date:</label>
                    <p><?php echo $exam['test_date']; ?></p>

                    <label>Final Placement</label>
                    <p><?php switch ($exam['final_score']) {
                                case 1:
                                    echo 'Level 1';
                                    break;
                                case 2:
                                    echo 'Level 2';
                                    break;
                                case 3:
                                    echo 'Level 3';
                                    break;
                                case 4:
                                    echo 'Credit Level';
                                    break;
                            } ?></p>
                    <label>Faculty Placement</label>
                    <p><?php echo $exam['faculty_score']; ?></p>
                    <label>English Level</label>
                    <p><?php switch ($exam['accuplacer_level']) {
                                case 0:
                                    echo 'Did Not Pass';
                                    break;
                                case 1:
                                    echo 'Level 1';
                                    break;
                                case 2:
                                    echo 'Level 2';
                                    break;
                                case 3:
                                    echo 'Level 3';
                                    break;
                                case 4:
                                    echo 'Credit Level';
                                    break;
                            } ?></p>
                    <label>Math Level</label>
                    <p><?php switch ($exam['math_level']) {
                                case 1:
                                    echo 'Level 1';
                                    break;
                                case 2:
                                    echo 'Level 2';
                                    break;
                                case 3:
                                    echo 'Level 3';
                                    break;
                                case 4:
                                    echo 'Credit Level';
                                    break;
                            } ?></p>
                    <label>Writing Sample Score</label>
                    <p><?php echo $exam['writing_sample_score']; ?></p>
                    <label>Accuplacer English Total Score</label>
                    <p><?php echo $exam['accuplacer_english_score']; ?></p>
                    <label>Math Total Score</label>
                    <p><?php echo $exam['math_score']; ?></p>

                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="examDetails">
                <div style="margin: 5px;" class="well">
                    <legend>Overall</legend>
                    <label>Overall Grade:</label>
                    <p><?php echo $exam['overall_grade']; ?></p>
                    <label>Overall Percent Score:</label>
                    <p><?php echo $exam['overall_percent_score'].'%'; ?></p>
                    <label>Overall Total Score</label>
                    <p><?php echo $exam['overall_total_score']; ?></p>
                    <legend>Language</legend>
                    <label>Language Grade:</label>
                    <p><?php echo $exam['lu_grade']; ?></p>
                    <label>Language Percent Score:</label>
                    <p><?php echo $exam['lu_percent_score'].'%'; ?></p>
                    <label>Language Total Score</label>
                    <p><?php echo $exam['lu_total_score']; ?></p>
                    <legend>Sentence Skill</legend>
                    <label>Sentence Skill Grade:</label>
                    <p><?php echo $exam['ss_grade']; ?></p>
                    <label>Sentence Skill Percent Score:</label>
                    <p><?php echo $exam['ss_percent_score'].'%'; ?></p>
                    <label>Sentence Skill Total Score</label>
                    <p><?php echo $exam['ss_total_score']; ?></p>
                    <legend>Reading</legend>
                    <label>Reading Grade:</label>
                    <p><?php echo $exam['rs_grade']; ?></p>
                    <label>Reading Percent Score:</label>
                    <p><?php echo $exam['rs_percent_score'].'%'; ?></p>
                    <label>Reading Total Score</label>
                    <p><?php echo $exam['rs_total_score']; ?></p>
                    <legend>Elementary Algebra</legend>
                    <label>Elementary Algebra Grade:</label>
                    <p><?php echo $exam['ea_grade']; ?></p>
                    <label>Elementary Algebra Percent Score:</label>
                    <p><?php echo $exam['ea_percent_score'].'%'; ?></p>
                    <label>Elementary Algebra Total Score</label>
                    <p><?php echo $exam['ea_total_score']; ?></p>
                    <legend>Arithmetic</legend>
                    <label>Arithmetic Grade:</label>
                    <p><?php echo $exam['a_grade']; ?></p>
                    <label>Arithmetic Percent Score:</label>
                    <p><?php echo $exam['a_percent_score'].'%'; ?></p>
                    <label>Arithmetic Total Score</label>
                    <p><?php echo $exam['a_total_score']; ?></p>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="admissionsRegistrations">
                <div class="form-group">
                    <label for="admissionComplete">Admission Completed:</label>
                    <input class="form-control" type="checkbox" name="admissionComplete" id="admissionComplete" <?php if($exam['admission_is_complete']==true) {echo 'checked';} ?>></input>
                </div>

                
                    <div class="form-group" id="admissionDateFormGroup">
                        <label for="admissionDate">Admission Date:</label>
                        <input class="form-control" type="date" name="admissionDate" id="admissionDate" value="<?php if($exam['admission_date']!=NULL) { echo strval(date_format(date_create($exam['admission_date']),'Y-m-d'));} ?>"></input>
                        <br>
                        <button type="button" id="saveAdmissionDate" class="btn btn-default">Save</button>
                    </div>

                

                <div class="form-group">
                    <label for="registerComplete">Register Completed:</label>
                    <input class="form-control" type="checkbox" name="registerComplete" id="registerComplete" <?php if($exam['is_registered']==true) {echo 'checked';} ?>></input>
                </div>

                
                <div class="form-group registerFormGroup">
                    <label for="registerYear">Registration Year:</label>
                    <input class="form-control" type="text" name="registerYear" id="registerYear" value="<?php echo $exam['registration_year']; ?>"></input>
                </div>

                <div class="form-group registerFormGroup">
                    <label for="registerSemester">Registration Semester:</label>
                    <select class="form-control" name="registerSemester" id="registerSemester">
                        <option <?php if ($exam['registration_semester']=="Fall") { echo 'selected';} ?>>Fall</option>
                        <option <?php if ($exam['registration_semester']=="Spring") { echo 'selected';} ?>>Spring</option>
                        <option <?php if ($exam['registration_semester']=="Summer") { echo 'selected';} ?>>Summer</option>
                    </select>
                    <br>
                    <button type="button" id="saveRegistrationYearSem" class="btn btn-default">Save</button>
                </div>
                

                <div class="form-group">
                    <label for="droppedSemester">Dropped Semester:</label>
                    <input class="form-control" type="checkbox" name="droppedSemester" id="droppedSemester" <?php if($exam['dropped_semester']==true) {echo 'checked';} ?>></input>
                </div>
            </div>
          </div>

        </div>
        </div>
    </div>
</div>
<div class="visible-print-block">
    <div><img style="display: block;margin-left: auto;margin-right: auto;" src="<?php echo base_url('assets/images/cmiSeal.png') ?>"></div>
    <h1 style="display: block;margin-left: auto;margin-right: auto;" align="center"><i>College of the Marshall Islands</i></h1>
    <h1 style="display: block;margin-left: auto;margin-right: auto;" align="center">Placement Test</h1>
    <h1><?php echo $exam['f_name'].' '.$exam['m_initial'].$exam['l_name']; ?></h1>
    <legend>English</legend>
    <label>Level:</label><p><?php switch ($exam['accuplacer_level']) {
                                case 0:
                                    echo 'Did Not Pass';
                                    break;
                                case 1:
                                    echo 'Level 1';
                                    break;
                                case 2:
                                    echo 'Level 2';
                                    break;
                                case 3:
                                    echo 'Level 3';
                                    break;
                                case 4:
                                    echo 'Credit Level';
                                    break;
                            } ?></p>
    <label>Total Score:</label><p><?php echo $exam['accuplacer_english_score']; ?></p>
    <div id="footer">
        Jomi Capelle (Director, Admissions and Records): _______________________________   Date: <?php echo date_format(date_create(), 'M d, Y'); ?>
    </div>
</div>
<script>
$(document).ready(function(){

    $('#printBtn').click(function() {
        window.print();
    });
    

    $('#admissionComplete').click(function() {
        $('#admissionDateFormGroup').toggle(this.checked);
        if ($('#admissionComplete').is(':checked')) {
            $('#admissionDate').val('');
        }
    })

    $('#registerComplete').click(function() {
        $('.registerFormGroup').toggle(this.checked);
        if ($('#registerComplete').is(':checked')) {
            $('#registerYear').val('');
            $('#registerSemester').val('');
        }
    })

    if ($('#admissionComplete').is(':checked')) {
        $('#admissionDateFormGroup').show();

    } else {
        $('#admissionDateFormGroup').hide();
    }

    if ($('#registerComplete').is(':checked')) {
        $('.registerFormGroup').show();
        
    } else {
        $('.registerFormGroup').hide();
    }

});

    $('#savePersonalInfo').click(function() {
        $.ajax({
           type: "POST",
           url: '<?php echo base_url('reviews/saveSisNameNumber'); ?>',
           data: $("#sisForm").serialize(),
           dataType: 'json',
           success: function(json){
            if (json.status != 'success') {
                alert('Unable to Update SIS Name/Number.');
            } else {
                alert('SIS Name/Number Updated.');
            }
           
           },
           error(a,b,c) {
            console.log(a);
            console.log(c);
           }
        });
    })

    $('#admissionComplete').change(function() {
        var id = <?php echo $id; ?>;
        var value = 0
        if (this.checked) {
            value = 1;
        } else {
            value = 0;
        }
        if (value == 0) {
            $('#admissionDate').val('');
        }
        $.ajax({
           type: "POST",
           url: '<?php echo base_url('reviews/saveAdmissionRegistrationDroppedSem'); ?>',
           data: {type: 'admission',value:value, id: id},
           dataType: 'json',
           success: function(json){
            if (json.status != 'success') {
                alert('Unable to Update Admissions.');
            } 
           },
           error(a,b,c) {
            console.log(a);
            console.log(c);
           }
        });
    })

    $('#saveAdmissionDate').click(function() {
        var id = <?php echo $id; ?>;
        var date = $('#admissionDate').val()
        $.ajax({
           type: "POST",
           url: '<?php echo base_url('reviews/saveAdmissionDate'); ?>',
           data: {date: date,id: id},
           dataType: 'json',
           success: function(json){
            if (json.status != 'success') {
                alert('Unable to Save Admission Date.');
            } else {
                alert('Admission Date Updated.');
            }
           
           },
           error(a,b,c) {
            console.log(a);
            console.log(c);
           }
        });
    })

    $('#registerComplete').change(function() {
        var id = <?php echo $id; ?>;
        var value = 0
        if (this.checked) {
            value = 1;
        } else {
            value = 0;
        }
        if (value == 0) {
            $('#registerYear').val('');
            $('#registerSemester').val('');
        }
        $.ajax({
           type: "POST",
           url: '<?php echo base_url('reviews/saveAdmissionRegistrationDroppedSem'); ?>',
           data: {type: 'register',value:value, id: id},
           dataType: 'json',
           success: function(json){
            if (json.status != 'success') {
                alert('Unable to Update Registration.');
            } 
           },
           error(a,b,c) {
            console.log(a);
            console.log(c);
           }
        });
    })

    $('#saveRegistrationYearSem').click(function() {
        var id = <?php echo $id; ?>;
        var year = $('#registerYear').val()
        var sem = $('#registerSemester').val()
        $.ajax({
           type: "POST",
           url: '<?php echo base_url('reviews/saveRegistrationYearSem'); ?>',
           data: {year: year,sem: sem,id: id},
           dataType: 'json',
           success: function(json){
            if (json.status != 'success') {
                alert('Unable to Save Year/Semester.');
            } else {
                alert('Year/Date Updated.');
            }
           
           },
           error(a,b,c) {
            console.log(a);
            console.log(c);
           }
        });
    })

    $('#droppedSemester').change(function() {
        var id = <?php echo $id; ?>;
        var value = 0
        if (this.checked) {
            value = 1;
        } else {
            value = 0;
        }
        $.ajax({
           type: "POST",
           url: '<?php echo base_url('reviews/saveAdmissionRegistrationDroppedSem'); ?>',
           data: {type: 'droppedSem',value:value, id: id},
           dataType: 'json',
           success: function(json){
            if (json.status != 'success') {
                alert('Unable to Update Semester Drop.');
            } 
           },
           error(a,b,c) {
            console.log(a);
            console.log(c);
           }
        });
    })
</script>