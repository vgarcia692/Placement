<div class="content">
    
    <div class="row">

        <div class="col-md-10 col-md-offset-1 well">
            <div><img style="display: block;margin-left: auto;margin-right: auto;" src="<?php echo base_url('assets/images/cmiSeal.png') ?>"></div>
            <button type="button" id="printBtn" class="btn hidden-print">Print</button>
            <h3 id="message"><label class="label label-info hidden-print"><?php if (isset($_SESSION['uploadMessage'])) {
                echo $_SESSION['uploadMessage'];
            } ?></label></h3>
                <legend>Uploaded Exams</legend>
                
                <?php foreach ($_SESSION['uploadResult'] as $exam) { ?>
                    <ul>
                        <li><?php echo $exam['id'].' - '.$exam['name'];?> </li>
                    </ul>
                <?php } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#printBtn').click(function() {
        window.print();
    });
</script>