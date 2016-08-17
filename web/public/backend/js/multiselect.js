/*
* @Author: doanlich
* @Date:   2016-07-29 09:04:16
* @Last Modified by:   doanlich
* @Last Modified time: 2016-08-17 14:44:15
*/
var checkboxName = 'tree_checkbox';

$(document).ready(function () {
    initLoadPage();
    $('#select-all').click(function () {
        $('.selection input[type="checkbox"]').prop('checked', true);
        var items = $('input[type="checkbox"][name^="'+checkboxName+'"]');
        $('.selected').empty();
        items.each(function (index, item) {
            addSelectedItem(item);
        });
    });
    $('#unselect-all').click(function () {
        $('.selected').empty();
        $('.selection input[type="checkbox"]').prop('checked', false);
    });
});
function processClick(checkbox)
{
    if(checkbox.checked) {
        processChecked(checkbox);
    } else {
        processUnChecked(checkbox);
    }
}

function processChecked(checkbox)
{
    if(checkbox.hasAttribute('data-parent')) {
        var parent = $(checkbox).data('parent');
        var parentSelector = 'checkbox-'+parent;
        $('#'+parentSelector).prop('checked', true);
    }
    processAddItem();
}

function processUnChecked(checkbox)
{
    if(checkbox.hasAttribute('data-parent')) {
        var parent = $(checkbox).data('parent');
        var parentSelector = 'checkbox-'+parent;

        var hasChecked = false;
        var childrens = $('input[data-parent="'+parent+'"]');
        childrens.each(function (index, children) {
            if(children.checked) {
                hasChecked = true;
                return;
            }
        });

        if(! hasChecked) {
            $('#'+parentSelector).prop('checked', false);
        }
    }
    $('#selected-'+checkbox.value).remove();
}

function processParentClick(checkbox)
{
    var value = checkbox.value;
    var childrens = $('input[data-parent="'+value+'"]');
    childrens.prop('checked', checkbox.checked);

    processAddItem();
}

function addSelectedItem(checkbox)
{
    var group = '<span class="pull-right text-right"><span class="label label-info flat">'+$('label[for="checkbox-'+$(checkbox).data('parent')+'"]').text().trim()+'</span></span>';
    if(!checkbox.hasAttribute('data-parent')) {
        group = '';
    }
    var item =  '<div id="selected-'+checkbox.value+'" class="input-group item">'
                    +'<span class="input-group-addon btn"><i class="fa-remove fa text-danger" onclick="removeSelectedItem('+checkbox.value+')"></i></span>'
                    +'<div class="form-control"><span class="pull-left">'+$(checkbox).data('content')+'</span> '+group+'</div>'
                +'</div>';
    $('.selected').append(item);
}

function removeSelectedItem(id)
{
    $('#selected-'+id).remove();
    $('#'+id).prop('checked', false);
    checkbox = document.getElementById(id);

    if(checkbox.hasAttribute('data-parent')) {
        var parent = $(checkbox).data('parent');
        var parentSelector = 'checkbox-'+parent;

        var hasChecked = false;
        var childrens = $('input[data-parent="'+parent+'"]');
        childrens.each(function (index, children) {
            if(children.checked) {
                hasChecked = true;
                return;
            }
        });

        if(! hasChecked) {
            $('#'+parentSelector).prop('checked', false);
        }
    }
}
function processAddItem()
{
    $('.selected').empty();
    var items = $('input[name^="'+checkboxName+'"]:checked');
    items.each(function (index, item) {
        addSelectedItem(item);
    });
}
function initLoadPage()
{
    $('.selected').empty();
    var items = $('input[name^="'+checkboxName+'"]:checked');
    items.each(function (index, item) {
        addSelectedItem(item);
        var parent = $(item).data('parent');
        var parentSelector = 'checkbox-'+parent;
        $('#'+parentSelector).prop('checked', true);
    });
}