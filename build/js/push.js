$(document).ready(function () {




    var formPush = $('#form-push').hide();
    var isiPush = $('#isiPush').hide();
    var conten = $('#push-content').show();

    $('#content-push').on('click', '.newCompos', function () {
        formPush.show();
        conten.hide();
    })

    $('#isiPush').on('click', '.replayPush', function () {
        var kode = $(this).data('kode');
        var nama = $(this).data('nama');
        var isi = 'Your Message here!';


        $('#replayidReff').val(kode);
        $('#replayKepada').val(nama);
        $('#replyPush').modal('show');
    })

    $('#form-push').on('submit', function (e) {
        e.preventDefault();
       var kepada   = $('#kepada').val();
       var adm      = $('#admin').val();
       var subject  = $('#subject').val();
       var isi      = $('#contentPush').val();
       var reff     = $('#idReff').val();


       $.ajax({
           url : 'php/ajx/PUSH.php?type=insert',
           type: 'post',
           data: 'kepada='+kepada+'&admin='+adm+'&id_reff='+reff+'&subject='+subject+'&isi='+isi,

           success: function (msg) {
               if(msg != ""){
                   alert(msg);
                   location.reload();
               }
           }
       });
    });

    $('#replay-push').on('submit', function (e) {
        e.preventDefault();

        var idReff = $('#replayidReff').val();
        var admin = $('#replayadmin').val();
        var replayisi = $('#replayPushISI').val();

        $.ajax({
            url : 'php/ajx/PUSH.php?type=replay',
            type: 'post',
            data: 'admin='+admin+'&id_reff='+idReff+'&isi='+replayisi,

            success: function (msg) {
                if(msg != ""){
                    alert(msg);
                    location.reload();
                }
            }
        });
    })

    $('#showPush').on('click', '.showMore', function () {
        var id = $(this).data('id');
        // alert(id);
        conten.hide();
        isiPush.hide().load('php/ajx/isi-push.php?kode_push='+id).fadeIn(600);
    })

    CKEDITOR.replace( 'contentPush' );

})

// function ShowPush(id) {
//     var idPush = id;
//     alert(idPush);
//     $(document).ready(function () {
//         $('#isiPush').hide();
//     })
// }