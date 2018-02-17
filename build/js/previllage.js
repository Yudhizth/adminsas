function getPrevillage(id, admin) {
    $.ajax({
        url : 'php/ajx/CRUD.php?type=addPrevillage',
        type: 'post',
        data: 'subcategory='+id+'&admin='+admin,

        success: function (msg) {
            if(msg != ""){
                alert(msg);
                location.reload();
            }
        }

    });
}
$(document).ready(function () {

    var list = $('#showPrevillage').hide();
    $('#contentPrevillage').on('click', '.showUserPrevillage', function () {
        var username = $(this).data('username');
        var id = $(this).data('roles');

       $('#contentPrevillage').hide();

       list.load('php/ajx/detailPrevillage.php?username='+username+'&roles='+id);
       list.show();
    });
})