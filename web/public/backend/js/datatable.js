/*
* @Author: doanlich
* @Date:   2016-07-27 14:42:52
* @Last Modified by:   doanlich
* @Last Modified time: 2016-07-28 10:12:30
*/

function confirmDeleteAll(that, selected = '')
{
    if(selected == ''){
        $('#common-modal .modal-body').html(emptyMessage);
        $('#common-modal').modal();
        return false;
    }
    var action = $(that).attr('href');

    if(that.hasAttribute('data-confirm')) {
        $('#confirm-modal .modal-body').html($(that).attr('data-confirm'));
    }
    if(that.hasAttribute('data-action')) {
        action = $(that).attr('data-action');
    }
    if(selected == '') {
        return false;
    }
    if($('#confirm-modal form #selected').length > 0) {
        $('#confirm-modal form #selected').val(selected);
    } else {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'selected';
        input.id = 'selected';
        input.value = selected;
        $(input).appendTo($('#confirm-modal form'));
    }
    $('#confirm-warning').hide();
    $('#confirm-modal form').attr('action', action);
    $('#confirm-modal').modal();

    return false;
}

function getSelected(name)
{
    return $('[name="'+name+'"]:checked').map(function() { return $(this).val().toString(); } ).get().join(",");
}

function checkSelectedAll(name)
{
    return $('input[name="'+name+'"]:checked').length == $('input[name="'+name+'"]').length;
}

function checkHasSelected(name)
{
    return $('input[name="'+name+'"]:checked').length > 0;
}

function enableDeleteSelectedButton()
{
    $('#datatable-delete-select-btn').removeAttr("disabled");
    $('#datatable-delete-select-btn').parent().removeClass("disabled");
}

function disableDeleteSelectedButton()
{
    $('#datatable-delete-select-btn').attr("disabled", "disabled");
    $('#datatable-delete-select-btn').parent().addClass("disabled");
}