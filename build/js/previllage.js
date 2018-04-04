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

    var list = $('#showPrevillage').show();
    $('#contentPrevillage').on('click', '.showUserPrevillage', function () {
        var username = $(this).data('username');
        var id = $(this).data('roles');

       $('#contentPrevillage').hide();

       list.load('php/ajx/detailPrevillage.php?username='+username+'&roles='+id);
       list.show();
    });

    $('#previllage').on('click', '.removePrevillage', function () {
        var id = $(this).data('id');
        var admin = $(this).data('admin');
        // alert(id);

        $.ajax({
            url : 'php/ajx/PUSH.php?type=removePrevillage',
            type: 'post',
            data: 'id_sub='+id+'&admin='+admin,

            success: function (msg) {
                if(msg != ""){
                    alert(msg);
                    location.reload();
                }
            }

        });
    })
})