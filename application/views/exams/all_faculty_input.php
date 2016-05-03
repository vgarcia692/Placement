<div class="content">
    <div class="row">
        <div><img style="display: block;margin-left: auto;margin-right: auto;" src="<?php echo base_url('assets/images/cmiSeal.png') ?>"></div>
        <button type="button" id="printBtn" class="btn hidden-print">Print</button>
        <div class="col-md-10 col-md-offset-1">
        <h4 class="errorlabel hidden-print"><?php if (isset($_SESSION['examScoreMessage'])) {echo $_SESSION['examScoreMessage'];} ?></h4>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Exam ID</th>
                        <th>Language Use Score</th>
                        <th>Sentence Skill Score</th>
                        <th>Reading Skill Score</th>
                        <th>Writing Sample Score</th>
                        <th>Final Placement</th>
                    </tr>
                </thead>
                <tbody>
                   <?php $i = $page + 1; ?>
                    <?php foreach ($exams as $exam) { ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $exam['id']; ?></td>
                            <td><?php echo $exam['lu_score']; ?></td>
                            <td><?php echo $exam['ss_score']; ?></td>
                            <td><?php echo $exam['rs_score']; ?></td>
                            <td><?php echo $exam['writing_sample_score']; ?></td>
                            <td>
                                <button type="button" class="btn btn-primary hidden-print" onclick="score('<?php echo $exam['id']; ?>','<?php echo $page; ?>')">Score Final Placement</button>
                            </td>
                        </tr>
                    <?php } ?>
                        
                </tbody>
            </table>
            <!-- Pagination Links -->
            <?php print_r($pagnation_links); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    function score(examId,page) {
        var url = "<?php echo base_url('faculties/scoreFinalPlacement').'/'; ?>";
        window.location= url+examId+'/'+page;
    }

    $('#printBtn').click(function() {
        window.print();
    });

</script>