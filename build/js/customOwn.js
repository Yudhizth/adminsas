$(document).ready(function() {

    $('#daftarKaryawan').on('click', '.tambahNIP', function () {
        var id = $(this).data('ktp');

        $.ajax({
            url   : 'php/ajx/CRUD.php?type=addNIP',
            type  : 'post',
            data  : 'ktp='+id,

            success: function (msg) {
                if(msg != ""){
                    alert(msg);
                    $('#daftarKaryawan').load(' #daftarKaryawan');
                }
            }
        });
    })
})