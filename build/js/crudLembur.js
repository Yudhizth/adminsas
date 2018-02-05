$(document).ready(function(){
    $('#listLembur').on('click', '.approveLembur', function () {
        var id = $(this).data('kode');
        var ktp = $(this).data('ktp');

        $.ajax({
            url : 'php/ajx/crudLembur.php?type=approve',
            type: 'post',
            data: 'kode='+id+'&ktp='+ktp,

            success: function (msg) {
                if(msg != ""){
                    alert(msg);
                    $('#listLembur').load(" #listLembur");
                }
            }

        });
    })
    $('#listLembur').on('click', '.declineLembur', function () {
        var id = $(this).data('kode');
        var ktp = $(this).data('ktp');
        $.ajax({
            url : 'php/ajx/crudLembur.php?type=decline',
            type: 'post',
            data: 'kode='+id+'&ktp='+ktp,

            success: function (msg) {
                if(msg != ""){
                    alert(msg);
                    $('#listLembur').load(" #listLembur");
                }
            }

        });
    })
})