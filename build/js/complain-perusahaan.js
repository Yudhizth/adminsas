function replayComplainCustomer(kupon, title, message, admin) {
    $.ajax({
        url : 'php/ajx/CRUD.php?type=replayCustomer',
        type: 'post',
        data: 'kupon='+kupon+'&title='+title+'&isi='+message+'&admin='+admin,

        success : function(msg){
            if(msg === '1'){
                alert('Berhasil membalas Komplain!');

                $('#formBalasComplainPerusahaan').hide();
                $('#showDetailComplain').hide().load('php/ajx/complainPerusahaan.php?kupon='+kupon+'&admin='+admin).fadeIn(700);

            }else{
                alert('Gagal membalas Komplain!');
            }

        }
    });



}
$(document).ready(function() {


    var table = $('#list_complain').DataTable({
        "scrollY": "500px",
        "paging": true
    });

    $('select.global_filter').on( 'keyup click', function () {
        filterGlobal();
    });

    $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();

        // Get the column API object
        var column = table.column( $(this).attr('data-column') );

        // Toggle the visibility
        column.visible( ! column.visible());

    });

    var detail = $('#contentComplain').hide();

    $('#listComplain').on('click', '.detailComplain', function () {
        var kupon  = $(this).data('kupon');
        var admin  = $(this).data('admin');

        $('#listComplain').hide();

        $('#showDetailComplain').load('php/ajx/complainPerusahaan.php?kupon='+kupon+'&admin='+admin);
        detail.show();
    });

    $('#showDetailComplain').on('click', '.formBalasComplain', function () {
        var id = $(this).data('kupon');
        var admin = $(this).data('admin');
        var id_reff = $(this).data('id');

        $('#showDetailComplain').hide();
        $('#formBalasComplainPerusahaan').load('php/ajx/modal.php?kupon='+id+'&admin='+admin+'&idReff='+id_reff);

    });

    $('#formBalasComplainPerusahaan').on('submit', '#replayComplain', function (event) {

        event.preventDefault();

        if($(this).parsley().validate()){
            var title = $('#titleComplain').val();
            var kupon = $('#reffComplain').val();
            var admin = $('#adminComplainID').val();
            var isi = $('#isiComplainPerusahaan').val();
            var id = $('#id_reff').val();

            // alert(title+ ' : ' +kupon+ ' : '+isi);

            $.ajax({
                url : 'php/ajx/CRUD.php?type=replayCP',
                type: 'post',
                data: 'kupon='+kupon+'&title='+title+'&isi='+isi+'&admin='+admin+'&id_reff='+id,

                success : function(msg){
                    if(msg === '1'){
                        alert('Berhasil membalas Komplain!');

                        $('#formBalasComplainPerusahaan').hide();
                        $('#showDetailComplain').hide().load('php/ajx/complainPerusahaan.php?kupon='+kupon+'&admin='+admin).fadeIn(700);

                    }else{
                        alert('Gagal membalas Komplain!');
                    }

                }
            })

        }
        else{
        }

    });

});