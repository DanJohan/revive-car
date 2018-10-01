$(function(){

	$("#order-form").validate({
      errorClass: "error",
      rules: {
        customer_request:{
          required:true
        },
        sa_remarks: {
          required: true,
        },
        parts_name: {
          required: true,
        },
        parts_price: {
          required: true,
          number: true
        },
        labour_price: {
          required: true,
          number: true
        },
        quantity: {
          required: true,
          digits: true
        },
        total_price: {
          required: true,
          number: true
        },
      },
    });

  $(document).on('click','.edit-job',function(){
    var btn = $(this);
    var jobId = btn.data('job-id');
    var jobCardId = btn.data('job-card-id');
    if(jobId){
      $.ajax({
        url:config.baseUrl+"workshop/jobCard/editRepairOrderView",
        method:"POST",
        data:{'job_id':jobId,'job_card_id':jobCardId},
        success:function(response){
          if(response.status){
          	$(".modal-content").html(response.template);
          	$("#basicModal").modal();
          }
        }
      });
    }
  });

$(document).on('click','.job-status',function(){
    var btn = $(this);
    var jobId = btn.data('job-id');
    var jobCardId = btn.data('job-card-id');
    if(jobId){
      $.ajax({
        url:config.baseUrl+"workshop/jobCard/changeStatusView",
        method:"POST",
        data:{'job_id':jobId,'job_card_id':jobCardId},
        success:function(response){
          if(response.status){
          	$(".modal-content").html(response.template);
          	$("#basicModal").modal();
          }
        }
      });
    }
  });

});
