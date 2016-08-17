/*
* @Author: doanlich
* @Date:   2016-07-27 16:31:53
* @Last Modified by:   doanlich
* @Last Modified time: 2016-08-16 14:52:25
*/
var emptyMessage = 'Please select item';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
    $('.fadeOut').delay(10000).fadeOut();
    $('[data-toggle="popover"]').popover();
});
function confirmAction(that)
{
    var action = $(that).attr('href');

    if(that.hasAttribute('data-confirm')) {
        $('#confirm-modal .modal-body').html($(that).attr('data-confirm'));
    }
    if(that.hasAttribute('data-action')) {
        action = $(that).attr('data-action');
    }
    $('#confirm-warning').hide();
    $('#confirm-modal form').attr('action', action);
    $('#confirm-modal').modal();

    return false;
}

function executeAjaxAction(form)
{
    var url = $(form).attr('action');
    $.ajax({
        url: url,
        dataType: "JSON",
        type: "POST",
        data: $(form).serialize(),
        beforeSend: function() {
            $('#confirm-warning .message').html('');
            $('#confirm-warning').hide();
            $('.overlay').show();
            $('#confirm-modal').modal('hide');
        },
        success: function(data) {
            $('.overlay').hide();
            if(data.res == 1) {
                $('#confirm-warning').hide();
                $('#confirm-modal').modal('hide');
                window.location.replace(data.url);
            } else {
                $('#confirm-warning .message').html(data.error);
                $('#confirm-warning').show();
                $('#confirm-modal').modal();
            }
        },
        error: function(x, y, z) {
            $('.overlay').hide();
            $('#confirm-warning .message').html(z);
            $('#confirm-warning').show();
            $('#confirm-modal').modal();
        }
    });

    return false;
}