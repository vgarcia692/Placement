<div class="content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        <h4 class="errorlabel"><?php if (isset($_SESSION['error'])) {echo $_SESSION['error'];} ?></h4>
        </div>

        <div class="col-md-10 col-md-offset-1">
        <legend>Select a High School:</legend>
            <ul>
                <?php foreach ($schools as $school) { ?>
                    <li><a href="<?php echo base_url('reviews/allExams').'/'.$school['high_school']; ?>"><?php echo $school['high_school']; ?></a></li>
                <?php } ?>  
            </ul>
        </div>
    </div>
</div>