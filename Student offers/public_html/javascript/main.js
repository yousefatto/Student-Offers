function myFunction() {
  $.ajax({
    url: "<?php echo url_for('user/pages/view_notification.php'); ?>",
    type: "POST",
    processData:false,
    success: function(data){
      console.log(data);
      $("#notification-count").remove();
      $("#notification-latest").show();$("#notification-latest").html(data);
    },
    error: function(){}
  });
 }

 $(document).ready(function() {
  $('body').click(function(e){
    if ( e.target.id != 'notification-icon'){
      $("#notification-latest").hide();
    }
  });
});
