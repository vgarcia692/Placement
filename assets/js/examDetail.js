$(document).ready(function(){

    $('#tookExamChk').click(function() {
        $('#didTakeBeforeDiv').toggle(this.checked);
    })

    $('#admissionComplete').click(function() {
        $('#admissionDateFormGroup').toggle(this.checked);
    })

    $('#registerComplete').click(function() {
        $('.registerFormGroup').toggle(this.checked);
    })



});

('#savePersonalInfo').click(function() {
    var sisName = $('#sisName').val();
    var sisNumber = $('#sisNumber').val();
    $.ajax({
       type: "POST",
       url: '<?php echo base_url('reviews/save_sis_name_number'); ?>',
       data: "sisName="+sisName+",sisNumber"+sisNumber,
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