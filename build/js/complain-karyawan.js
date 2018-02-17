function replayComplainKaryawan(kupon, title, message, admin) {
    $.ajax({
        url : 'php/ajx/CRUD.php?type=replayKaryawan',
        type: 'post',
        data: 'kupon='+kupon+'&title='+title+'&isi='+message+'&admin='+admin,

        success : function(msg){
            if(msg === '1'){
                alert('Berhasil membalas Komplain!');

                $('#replayComplainKaryawan').hide();
                $('#detailKomplainKaryawan').hide().load('php/ajx/complainKaryawan.php?kupon='+kupon+'&admin='+admin).fadeIn(500);

            }else{
                alert('Gagal membalas Komplain!');
            }

        }
    });
}
$(document).ready(function() {


    var table = $('#list_complain_karyawan').DataTable({
        "scrollY": "500px",
        "paging": true
    });

    $('select.global_filter').on('keyup click', function () {
        filterGlobal();
    });

    $('a.toggle-vis').on('click', function (e) {
        e.preventDefault();

        // Get the column API object
        var column = table.column($(this).attr('data-column'));

        // Toggle the visibility
        column.visible(!column.visible());

    });



    $('#listComplainKaryawan').on('click', '.detailComplainKaryawan', function () {
        var kupon = $(this).data('kupon');
        var admin = $(this).data('admin');

        $('#listComplainKaryawan').hide();
        $('#detailKomplainKaryawan').hide().load('php/ajx/complainKaryawan.php?kupon='+kupon+'&admin='+admin).fadeIn(1000);

    });

    $('#detailKomplainKaryawan').on('click', '.formBalasComplainKaryawan', function () {
        var id = $(this).data('kupon');
        var admin = $(this).data('admin');
        //
        // $('#contentComplainKaryawan').hide().fadeOut(500);

        $('#formComplainKaryawan').hide().load('php/ajx/formKomplainKaryawan.php?kupon='+id+'&admin='+admin).fadeIn(500);

    });


    $('#detailKomplainKaryawan').on('submit', '#replayComplainKaryawan', function (event) {

        event.preventDefault();

        if($(this).parsley().validate()){
            var title = $('#titleKaryawanKomplain').val();
            var kupon = $('#reffKaryawan').val();
            var admin = $('#adminKaryawanID').val();
            var isi = $('#isiComplainKaryawan').val();

            // alert(title+ ' : ' +kupon+ ' : '+isi+ ' : '+admin);

            $.ajax({
                url : 'php/ajx/CRUD.php?type=replayKaryawan',
                type: 'post',
                data: 'kupon='+kupon+'&title='+title+'&isi='+isi+'&admin='+admin,

                success : function(msg){
                    if(msg === '1'){
                        alert('Berhasil membalas Komplain!');


                    }else{
                        alert('Gagal membalas Komplain!');
                    }

                }
            })

        }
        else{
        }

    });


})