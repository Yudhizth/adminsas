$(document).ready(function () {

    var form = $('#rangeCuti').hide();
    var admin = $('#adminID').val();

    var list = $('#showListCuti').load('php/ajx/detailCuti.php?admin='+admin);

    $('#showListCuti').on('click', '.actCuti', function () {
        var id = $(this).data('id');
        var admin = $(this).data('admin');
        var type = $(this).data('type');
        $.ajax({

           url  : 'php/ajx/CRUD.php?type=actCuti',
            type: 'post',
            data: 'idKtp='+id+'&admin='+admin+'&type='+type,

            success : function (msg) {
                if(msg != ''){
                    alert(msg);
                    var list = $('#showListCuti').hide().load('php/ajx/detailCuti.php?admin='+admin).fadeIn(1500);
                }
            }
        });
    });
});