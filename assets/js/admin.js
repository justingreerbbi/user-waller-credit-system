(function($){
  
  /** intiate jQuery tabs */
  $("#wo_tabs").tabs({
    activate: function(event, ui) {
      //window.location.hash = ui.newPanel.attr('id'); // Does not seem to work 100%
    }
  });

  $('#adjust-users-virtual-wallet').submit(function(e){
    $('#adjust-users-virtual-wallet').children('#submit').hide();
    e.preventDefault();
    var formData = $(this).serialize();
    //console.log(formData);
    var data = {
      'action': 'wpvw_adjust_user_wallet',
      'data': formData
    };
    // We can also pass the url value separately from ajaxurl for front end AJAX implementations
    jQuery.post(ajaxurl, data, function(response) {
      var res = jQuery.parseJSON( response );
      if(res.status)
      {
        //alert(res.credit_amount);
        alert(res.message);
        $('#adjust-users-virtual-wallet').children('#submit').show();
        tb_remove();
      }
      else
      {
        alert(res.message);
        $('#adjust-users-virtual-wallet').children('#submit').show();
      }

    });
  });

  /*$('#onchange-get-balance').change(function(){
    var data = {
      'action': 'wpvw_get_user_balance',
      'user_id': $(this).val()
    };
    // We can also pass the url value separately from ajaxurl for front end AJAX implementations
    jQuery.post(ajaxurl, data, function(response) {
      var res = jQuery.parseJSON( response );
      if(res.status)
      {
        $('.selected-user-balance').html('Current Balance: $' + res.balance);
      }

    });

  });
*/

  /*$("#amount").on("keyup", function(){
    var valid = /^\d{0,4}(\.\d{0,2})?$/.test(this.value),
        val = this.value;
    
    if(!valid){
        console.log("Invalid input!");
        this.value = val.substring(0, val.length - 1);
    }
  });
*/

})(jQuery);