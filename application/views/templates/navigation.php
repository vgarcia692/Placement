<script src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#"><span><img src="<?php echo base_url("assets/images/cmiSeal.png")?>" width="55px" height="35" style="margin-right:10px;padding-bottom:5;">CMI Placement</span></a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <?php if(isset($_SESSION['userType'])) { ?>
                <li><a href="<?php echo base_url('auth/logout'); ?>">Logout</a><li>
                <li role="presentation" class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Menu</a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url('user/dashboard'); ?>">Home</a></li>
                        <?php if ($_SESSION['userType']=='admin') { ?>
                            <li><a href="<?php echo base_url('upload/uploadForm'); ?>">Upload</a></li>
                            <li><a href="<?php echo base_url('faculties/allFacultyInput'); ?>">Faculty Input</a></li>
                            <li><a href="<?php echo base_url('reviews/listSchools') ?>">Review Exams</a></li>
                            <li><a href="<?php echo base_url('reports/listReports'); ?>">Reports</a></li>
                        <?php } ?>
                        
                        <li><a href="<?php echo base_url('scorings/allScoringExams') ?>">Score Exams</a></li>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>