function ChangeStatusKaryawan(ktp, id) {
    $.ajax({
        url : 'php/ajx/crudKaryawanProject.php?type=changeStatus',
        type: 'post',
        data: 'ktp='+ktp+'&st='+id,

        success: function (msg) {
            if(msg != ""){
                console.log(ktp);
                alert(msg);
                location.reload();
            }
        }

    });
}
$(document).ready(function(){

    $('#GenerateListKaryawan').on('click', function () {
        var id = $('#GenerateListKaryawan').data('kode');
        var spk = $('#GenerateListKaryawan').data('spk');

        $.ajax({
            url : 'php/ajx/crudKaryawanProject.php?type=generate',
            type: 'post',
            data: 'kodeGenerate='+id+'&spk='+spk,

            success: function (msg) {
                if(msg != ""){
                    alert(msg);
                    location.reload();
                }
            }

        });
    });
   $('#listKaryawan').on('click', '.tambahKaryawan', function () {

       var spk = $(this).data('kode');
       var ktp = $(this).data('ktp');

       if(! confirm('Are you sure want to add?')){
           return false;

       }else{
           $('#ModalContoh').modal('show');
           $('#noKTPKaryawan').val(ktp);
       }
       // $.ajax({
       //     url : 'php/ajx/crudKaryawanProject.php?type=addKaryawan',
       //     type: 'post',
       //     data: 'spk='+spk+'&ktp='+ktp,
       //
       //     success: function (msg) {
       //         if(msg != ""){
       //             alert(msg);
       //             location.reload();
       //         }
       //     }
       //
       // });
   });

    $('#ModalContoh').on('hidden.bs.modal', function (e) {
        $('#noKTPKaryawan').val();
        $('#posisiLamaran').val();
    })

    $('#karyawanSelected').on('click', '.removeKaryawanProject', function () {

        var ktp = $(this).data('ktp');
        var kode = $(this).data('kd');

        $.ajax({
            url : 'php/ajx/crudKaryawanProject.php?type=removeKaryawan',
            type: 'post',
            data: 'kode='+kode+'&ktp='+ktp,

            success: function (msg) {
                if(msg != ""){
                    alert(msg);
                    location.reload();
                }
            }

        });
    });

   $('#karyawanSelected').on('click', '.finishAddKaryawan', function () {

       var nomor = $(this).data('request');
       $.ajax({
           url : 'php/ajx/crudKaryawanProject.php?type=finishAdd',
           type: 'post',
           data: 'kode='+nomor,

           success: function (msg) {
               if(msg === "0"){
                   alert("Data Karyawan Kurang Memadai.");
                   location.reload();
               }else if(msg === '1'){
                   alert("Karywan Telah ditambahkan.");
                   window.location.href='?p=entry-data';
               }
           }

       });

   });

//MPO semua inih
    $('#listMPO').on('click', '.tambahMPO', function () {

       if(! confirm('Are you sure want to add?')){
           return false;

       }else{
           var spk = $(this).data('kode');
           var ktp = $(this).data('ktp');
           var posisi = $(this).data('posisi');

           $('#ModalContoh').modal('show');
           $('#noKTPKaryawan').val(ktp);
           $('#posisiLamaran').val(posisi);
           // $.ajax({
           //     url : 'php/ajx/crudKaryawanProject.php?type=addKaryawanMPO',
           //     type: 'post',
           //     data: 'spk='+spk+'&ktp='+ktp+'&posisi='+posisi,
           //
           //     success: function (msg) {
           //         if(msg != ""){
           //             alert(msg);
           //             location.reload();
           //         }
           //     }
           //
           // });
       }
    });
    $('#pilihLokasiKaryawan').on('submit', function (e) {
        e.preventDefault();

        var kode = $('#kodeKaryawan').val();
        var ktp = $('#noKTPKaryawan').val();
        var lokasi = $('#lokasiKaryawan option:selected').val();
        var posisi = $('#posisiLamaran').val();
        $.ajax({
            url : 'php/ajx/crudKaryawanProject.php?type=addKaryawan',
            type: 'post',
            data: 'spk='+kode+'&ktp='+ktp+'&lokasi='+lokasi+'&posisi='+posisi,

            beforeSend: function ( xhr ) {
               $('#addtempatBtn').addClass('hidden');
               $('#loadBtnTempat').html('Please wait while Saving!');
            },
            success: function (msg) {
                if(msg != ""){
                    alert(msg);
                    location.reload();
                }
            }

        });
    });
   $('#selectMPO').on('change', function () {

       var id = $(this).find('option:selected');
       var kode = id.val();
       var generate = $(this).find('option:selected');
       var kodeList = generate.data('karyawan');
       var isi = id.data('id');

       $('#listMPO').load('php/ajx/selectMPO.php?kode='+kode+'&id='+isi+'&generate='+kodeList);
   })

    $('#componenProject').on('click', '.addRating', function () {
       var id = $(this).data('kode');
       console.log(id);

       $('#idReportJobs').val(id);
    });


    $('#tambahRatingKaryawan').on('submit', function (e) {
        e.preventDefault();

        if($(this).parsley().validate()){

            var id = $('#idReportJobs').val();
            var star = $('#starJobs option:selected').val();
            var admin = $('#idAdminJobs').val();

            $.ajax({
                url : 'php/ajx/crudKaryawanProject.php?type=addRating',
                type: 'post',
                data: 'id='+id+'&star='+star+'&admin='+admin,

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

    $('#dataKontrak').on('click', '.generateInvoice', function () {
        var kontrak = $(this).data('kontrak');

        $.ajax({
            url : 'php/ajx/crudKaryawanProject.php?type=generateInvoice',
            type: 'post',
            data: 'kontrak='+kontrak,

            success : function(msg){
                if(msg != ''){
                    alert(msg);
                    location.reload();
                }

            }
        })
    })



})