//submit form using ajax
$(document).on('submit' , '.ajax-form' , function () {
    var form = $(this);
    var url = form.attr('action');
    var formData = new FormData(form[0]);
    form.find(":submit").attr('disabled' , true).html('Please wait');

    $.ajax({
        url : url,
        method : 'POST',
        dataType: 'json',
        data : formData,
        contentType:false,
        cache: false,
        processData:false,
        success : function (response) {
            notification("success", response.message ,"fas fa-check");
            setTimeout(function () {
                if (response.url) {
                    window.location.href = response.url;    
                }else{
                    window.location.reload();
                }
                
            }, 2000);
        },
        error : function (jqXHR) {
            var response = $.parseJSON(jqXHR.responseText);
            notification("danger", response ,"fas fa-times");
            form.find(":submit").attr('disabled' , false).html('Store');
        }
    });
    $.ajaxSetup({
        headers:
            {
                'X-CSRF-Token': $('input[name="_token"]').val()
            }
    });
    return false;
});
$(".jfilestyle").jfilestyle({
    // theme: "blue",
    text: " Add Images ",
    // placeholder: " Add images ",
});

//bootstrap notify
function notification(type, message ,icon) {
    var content = {};

    content.message = message;
    content.icon = icon;

    var notify = $.notify(content, {
        type: type,
        allow_dismiss: false,
        newest_on_top: true,
        mouse_over: true,
        spacing: 10,
        timer: 2000,
        placement: {
            from: 'bottom',
            align: $('html').attr('lang') == 'ar' ? "left" :  "right" // isRTL() ? 'left' :
        },
        offset: {
            x: 10,
            y: 10
        },
        delay: 1000,
        z_index: 99999999,
        animate: {
            enter: "animated fadeInUp",
            exit: "animated fadeOutDown"
        }
    });
}

