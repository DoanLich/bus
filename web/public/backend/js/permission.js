/*
* @Author: doanlich
* @Date:   2016-07-27 09:19:56
* @Last Modified by:   doanlich
* @Last Modified time: 2016-07-27 09:27:21
*/

$(document).ready(function () {
    initPermissionForm();

    $('#permission_group').change(function () {
        loadOtherGroupField();
    });
});

function initPermissionForm()
{
    loadOtherGroupField();
}

function loadOtherGroupField()
{
    var selectedGroup = $('#permission_group').val();
    if(selectedGroup == -1) {
        $('#permission_other_group').show();
    } else {
        $('#permission_other_group').val('');
        $('#permission_other_group').hide();
    }
}