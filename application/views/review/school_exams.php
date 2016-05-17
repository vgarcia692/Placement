<script>
$(function(){
    $("#pagination-div-id a").click(function(){
        var q = $('#search').val();
        $.ajax({
           type: "POST",
           url: $(this).attr("href"),
           data: "search="+q,
           success: function(res){
              $("#containerid").html(res);
           }
        });
        return false;
    });

    $('#searchBtn').click(function() {
        var q = $('#search').val();
        $.ajax({
           type: "POST",
           url: '<?php echo base_url('reviews/allExams/'.$hs); ?>',
           data: "search="+q,
           success: function(res){
              $("#containerid").html(res);
           },
           error(a,b,c) {
            console.log(a);
            console.log(c);
           }
        });
        return false;
    })

    $("#clearSearchBtn").click(function(){
        $.ajax({
           type: "POST",
           url: $(this).attr("href"),
           success: function(res){
              $("#containerid").html(res);
           }
        });
        return false;
    });
});
</script>
<div class="content" id="containerid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        <h4 class="errorlabel"><?php if (isset($_SESSION['error'])) {echo $_SESSION['error'];} ?></h4>
        </div>

        <div class="col-md-10 col-md-offset-1">
        <legend><?php echo $hs; ?> Exams:</legend>
        
        <input id="search" name="search" type="text" placeholder="Search Name" <?php if (isset($searchTerm)) {?> value="<?php echo $searchTerm ?>"<?php } ?>></>
        <button id="searchBtn" type="button" class="btn btn-default">Search</button>
        <button id="clearSearchBtn" type="button" class="btn btn-default">Clear Search</button>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Exam Number</th>
                    <th>Test Date</th>
                    <th>Name</th>
                    <th>Placement</th>
                    <th>Taken Before?</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                
                    <?php foreach ($exams as $exam) { ?>
                    <tr>
                        <td><a href="<?php echo base_url('reviews/exam/'.$exam['id']); ?>"><?php echo $exam['id']; ?></a></td>
                        <td><?php echo date_format(date_create($exam['test_date']), 'M d, Y'); ?></td>
                        <td><?php echo $exam['name']; ?></td>
                        <td> Final:
                        
                        <?php 
                            switch ($exam['final_score']) {
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
                            }
                        ?>
                    <br>
                    Math: <?php
                        switch ($exam['math_level']) {
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
                            }
                    ?></td>
                        <td><?php echo $exam['taken_before']; ?></td>
                    </tr>
                    <?php } ?>
                    
            </tbody>
        </table>
        <div id='pagination-div-id'>
            <?php echo $pagnation_links; ?>
        </div>
        </div>
    </div>
</div>