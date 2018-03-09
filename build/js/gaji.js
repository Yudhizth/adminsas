$(document).ready(function(){

    var listBank = $('#list-bank').hide();

    var listGaji = $('#list-gaji').load('php/ajx/viewsGaji.php?type=views');

    $('#list-gaji').on('click', '.selectBank', function () {

        $('#list-gaji').hide();
        listBank.show();

    });

    $('#formSelectBank').on('submit', function (e) {
        e.preventDefault();

        var kd = $('#listBank option:selected').val();

        listBank.hide();
        listGaji.hide().load('php/ajx/viewsGaji.php?type=selectedBank&kd='+kd).fadeIn(900);
    });

    $('#list-gaji').on('click', '.sendGaji', function (e) {
        e.preventDefault();

        var type = $(this).data('type');

        $.ajax({
            url : 'php/ajx/viewsGaji.php?type=inputGaji',
            type: 'post',
            data: 'data='+type,

            success: function (msg) {
                if(msg != ""){
                    alert(msg);
                    location.reload();
                }
            }

        });
    });



})