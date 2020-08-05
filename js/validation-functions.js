function isNumberKey(evt, field_id, error_id, length) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        // alert('hi');

        $('#'+error_id).html('Only Number');
        $('#'+error_id).addClass('label_error');
        $('#'+field_id).addClass('field_error');
        $('#'+field_id).next('.bar').addClass('bar_red');

        // $('#'+field_id).parents('.form-group').find('.floating-label').after('<span id="#'+error_id+'"></span>');

        event.preventDefault();
        return false;
    } else {
        if ($('#'+field_id).val().length==length-1) {
            $('#'+error_id).html('');
            $('#'+error_id).removeClass('label_error');
            $('#'+field_id).removeClass('field_error');
            $('#'+field_id).next('.bar').removeClass('bar_red');
        }else{
            $('#'+error_id).html('Invalid length ('+length+' digit only)');
            $('#'+error_id).addClass('label_error');
            $('#'+field_id).addClass('field_error');
            $('#'+field_id).next('.bar').addClass('bar_red');
        }
        return true;
    }
}

function isWebsiteKey(evt, field_id, error_id) {
    // var regex = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[\-;:&=\+\$,\w]+@)?[A-Za-z0-9\.\-]+|(?:www\.|[\-;:&=\+\$,\w]+@)[A-Za-z0-9\.\-]+)((?:\/[\+~%\/\.\w\-_]*)?\??(?:[\-\+=&;%@\.\w_]*)#?(?:[\.\!\/\\\w]*))?)/;
    var regex = /^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9](?:\.[a-zA-Z]{2,})+$/;
    var check = regex.test($('#'+field_id).val());
    if(check) {
            $('#'+error_id).html('');
            $('#'+error_id).removeClass('label_error');
            $('#'+field_id).removeClass('field_error');
            $('#'+field_id).next('.bar').removeClass('bar_red');
    } else {
        $('#'+error_id).html('Invalid URL. Example www.boovent.com');
        $('#'+error_id).addClass('label_error');
        $('#'+field_id).addClass('field_error');
        $('#'+field_id).next('.bar').addClass('bar_red');
    }
    
}

