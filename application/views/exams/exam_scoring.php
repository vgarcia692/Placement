<div class="content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        <h4 class="errorlabel"><?php if (isset($_SESSION['examScoreMessage'])) {echo $_SESSION['examScoreMessage'];} ?></h4>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Exam ID</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                   <?php $i = $page + 1; ?>
                    <?php foreach ($exams as $exam) { ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <?php if ($_SESSION['userType']=='admin') { ?>
                                <td><?php echo $exam['id'].' - '.$exam['name']; ?></td>
                            <?php } else { ?>
                                <td><?php echo $exam['id']; ?></td>
                            <?php } ?>
                            <td>
                                <button type="button" class="btn btn-primary" onclick="score('<?php echo $exam['id']; ?>','<?php echo $page; ?>')">Score</button>
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
        var url = "<?php echo base_url('scorings/scoreExam').'/'; ?>";
        window.location= url+examId+'/'+page;
    }
</script>