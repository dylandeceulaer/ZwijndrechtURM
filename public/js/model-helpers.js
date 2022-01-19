function searchById(myArray,id){
    for (var i=0; i < myArray.length; i++) {
        if (myArray[i].id == id) {
            return myArray[i];
        }
    }
}
jQuery.fn.extend({
    scrollToMe: function () {
      var x = jQuery(this).offset().top - 100;
      jQuery('html,body').animate({scrollTop: x}, 400);
   }});

function notify($status, $message){
    $icon = "";
    switch ($status) {
        case "success":
            $icon = "fa fa-check"
            break;
        case "danger":
            $icon = "fa fa-times"
            break;
        case "info":
            $icon = "fa fa-info-circle"
            break;
        case "warning":
            $icon = "fa fa-exclamation-triangle"
            break;
        default:
            break;
    } 
    $.notify({
        icon: $icon,
        message: $message
    },{
        type: $status,
        allow_dismiss: true,
        offset: 20,
        spacing: 10,
        z_index: 100000,
        delay: 5000,
        timer: 1000,
    },{
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        }
    });
}