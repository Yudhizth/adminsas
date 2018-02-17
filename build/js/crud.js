function addDetail() {
    var id = $('.tambahDetail').data('id');
    var admin = $('.tambahDetail').data('admin');

    alert(id);
    
}
$(document).ready(function(){

    var spk   = $('#txtSPK').val();

    $('#formJudul').on('submit', function(event){
        event.preventDefault();

        if($(this).parsley().validate()){
            
            var spk   = $('#txtSPK').val();
            var id    = $('#txtID').val();
            var judul = $('#txtJudul').val();
            var type = $('#txtType option:selected').val();

            $.ajax({
                url : 'php/ajx/crudJob.php?type=addJudul',
                type: 'post',
                data: 'spk='+spk+'&judul='+judul+'&id='+id+'&type='+type,

                success : function(msg){
                    if(msg != ''){
                        alert(msg);
                        location.reload();
                        $('#formJudul #txtJudul').val('');
                        $( "#listPanel" ).load( "?p=add-list-job&name="+spk+" #listPanel" );
                        $( "#formJudul1" ).load( "?p=add-list-job&name="+spk+" #formJudul1" );
                    }

                }
            });
        }
        else{
            alert('System Error');
        }
    });

    $('#formJudulMPO').on('submit', function(event){
        event.preventDefault();

        if($(this).parsley().validate()){

            var spk   = $('#txtSPK').val();
            var id    = $('#txtID').val();
            var type = $('#txtType option:selected').val();
            var judul = $('#txtJudul option:selected').val();

            $.ajax({
                url : 'php/ajx/crudJob.php?type=addJudul',
                type: 'post',
                data: 'spk='+spk+'&judul='+judul+'&id='+id+'&type='+type,

                success : function(msg){
                    if(msg != ''){
                        alert(msg);
                        location.reload();

                        $( "#listPanel" ).load( "?p=add-list-job&name="+spk+" #listPanel" );
                        $( "#formJudulMPO" ).load( "?p=add-list-job&name="+spk+" #formJudulMPO" );
                    }

                }
            });
        }
        else{
            alert('System Error');
        }
    });

    $('#listPanel').on('click', '.tambahDetail', function () {
        var id = $(this).data('id');
        var admin = $(this).data('admin');


        $('#inputDetail').load('php/ajx/addDetailJobs.php?id='+id+'&admin='+admin);
    })

    $('#listPanel').on('click', '.tambahDetailMPO', function () {
        var id = $(this).data('id');
        var admin = $(this).data('admin');


        $('#inputDetail').load('php/ajx/addDetailJobs.php?id='+id+'&admin='+admin);
    })

    $('#inputDetail').on('submit', '#detailJob', function(event){
        event.preventDefault();

        if($(this).parsley().validate()){
            var spk   = $('#txtSPK').val();
            var kode = $('#txtKodeDetail').val();
            var admin = $('#txtAdmin').val();
            var kegiatan = $('#txtKegiatan').val();
            var deskripsi = $('#txtDeskripsi').val();
            var keterangan = $('#txtKeterangan').val();

            // alert(spk + kode + admin + kegiatan + deskripsi + keterangan);

            $.ajax({
                url : 'php/ajx/crudJob.php?type=addDetail',
                type: 'post',
                data: 'kode='+kode+'&admin='+admin+'&kegiatan='+kegiatan+'&deskripsi='+deskripsi+'&keterangan='+keterangan,

                success : function(msg){
                    if(msg != ''){
                        alert(msg);
                        location.reload();
                        $( "#listPanel" ).load("?p=add-list-job&name="+spk+" #listPanel");
                        $('#detailJob').load("?p=add-list-job&name="+spk+" #detailJob");
                        $('#tableDetail').load("?p=add-list-job&name="+spk+" #tableDetail");
                    }

                }
            })

        }
        else{
            alert('Mohon di perhatikan!');
        }
    });

    $('#listPanel').on('click', '.removeDetail', function(){
            var id = $(this).data('id');

            $.ajax({
                url : 'php/ajx/crudJob.php?type=deleteDetail',
                type: 'post',
                data: 'id='+id,

                success : function(msg){
                    if(msg != ''){
                        alert(msg);
                        location.reload();

                        $( "#listPanel" ).load("?p=add-list-job&name="+spk+" #listPanel");
                        $('#detailJob').load("?p=add-list-job&name="+spk+" #detailJob");
                    }

                }
            })
    });

    $('#listPanel').on('click', '.removeTitle', function () {
        var id = $(this).data('id');

        $.ajax({
            url : 'php/ajx/crudJob.php?type=deleteTitle',
            type: 'post',
            data: 'id='+id,

            success : function(msg){
                if(msg != ''){
                    alert(msg);
                    location.reload();
                    $( "#listPanel" ).load("?p=add-list-job&name="+spk+" #listPanel");
                    $('#detailJob').load("?p=add-list-job&name="+spk+" #detailJob");
                }

            }
        })
    });



    $('#listPanel').on('click', '.finishJobs', function () {
        var id = $(this).data('spk');


        $.ajax({
            url : 'php/ajx/crudJob.php?type=finishJobs',
            type: 'post',
            data: 'id='+id,

            success : function(msg){
                if(msg != ''){
                    window.location.href='?p=entry-data';
                }

            }
        })
    });

    $('#requestKebutuhanPerusahaanMPO').hide();
    $('#listKebutuhanPerusahaanMPO').hide();
    $('#tambahJabatanKaryawan').on('submit', function (e) {
        e.preventDefault();

       if($(this).parsley().validate()){

           var kode = $('#kodeListKaryawan').val();
           var idKtp = $('#namaKaryawanPR option:selected').val();
           var idJabatan = $('#listJabatan option:selected').val();

           $.ajax({
               url : 'php/ajx/CRUD.php?type=addJabatan',
               type: 'post',
               data: 'kode='+kode+'&ktp='+idKtp+'&jabatan='+idJabatan,

               success : function(msg){
                   if(msg != ''){
                       alert(msg);
                       location.reload();
                   }

               }
           })
       }else{

       }
    });

    $('#formRequestKebutuhan').on('submit', function (e) {
        e.preventDefault();

        var perusahaan = $('#listPerusahaan option:selected').val();
        var kebutuhan = $('#listKebutuhan option:selected').val();

        if($(this).parsley().validate()){

            if(kebutuhan === 'MPO01'){
                $('#txtPerusahaan').val(perusahaan);
            }else{

            }

        }else{
            var btn = $('.buttooom').html('try again');
            btn.removeClass('btn-primary');
            btn.addClass('btn-danger');
        }
    });

    
})