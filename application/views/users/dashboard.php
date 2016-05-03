<div class="content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <?php if ($_SESSION['userType']=='admin') { ?>
            <div class="col-md-3">
                <a href="<?php echo base_url('upload/uploadForm'); ?>"><img class="dashboardIcon" src="<?php echo base_url('assets/images/interface.svg'); ?>"></a>
                <h3 class="dashboardText">Upload</h3>
            </div>
            <?php } ?>
            <?php if ($_SESSION['userType']=='admin') { ?>
                <div class="col-md-3">
                    <a href="<?php echo base_url('faculties/allFacultyInput'); ?>"><img class="dashboardIcon" src="<?php echo base_url('assets/images/editing.svg'); ?>"></a>
                    <h3 class="dashboardText">Faculty Input</h3>
                </div>
            <?php } ?>
            <div class="col-md-3">
                <a href="<?php echo base_url('scorings/allScoringExams') ?>"><img class="dashboardIcon" src="<?php echo base_url('assets/images/crowd-of-users.svg'); ?>"></a>
                <h3 class="dashboardText">Writing Sample Scoring</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <?php if ($_SESSION['userType']=='admin') { ?>    
                <div class="col-md-3">
                    <a href="<?php echo base_url('reviews/listSchools') ?>"><img class="dashboardIcon" src="<?php echo base_url('assets/images/crowd-of-users.svg'); ?>"></a>
                    <h3 class="dashboardText">Review Exams</h3>
                </div>
                <div class="col-md-3">
                    <a href="<?php echo base_url('reports/listReports'); ?>"><img class="dashboardIcon" src="<?php echo base_url('assets/images/check.svg'); ?>"></a>
                    <h3 class="dashboardText">Reporting</h3>
                </div>
            <?php } ?>
        </div>
        
    </div>
</div>