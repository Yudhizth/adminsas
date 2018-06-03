function sendInvoice(id, spk) {
    $.ajax({
        url: 'php/ajx/CRUD.php?type=invoice',
        type: 'post',
        data: 'nomor=' + id + '&kode=' + spk,

        success: function(msg) {
            if (msg != '') {
                alert(msg);
                window.location.reload();
            }

        }
    });
}

function activeCompany(type, id) {
    $.ajax({
        url: 'php/ajx/CRUD.php?type=changeStatus',
        type: 'post',
        data: 'type=' + type + '&kode_perusahaan=' + id,

        success: function(msg) {
            if (msg != '') {
                alert(msg);
                window.location.reload();
            }

        }
    });
}

function showFilter() {
    $('#form_filter').removeClass('hidden');
    $('#btnFilter').addClass('hidden');
}

function addDetail() {
    var id = $('.tambahDetail').data('id');
    var admin = $('.tambahDetail').data('admin');

    alert(id);

}

function formArtikel() {
    $('#artikel-form').removeClass('hidden');
    $('#conten-artikel').hide();
}
$(document).ready(function() {

    var spk = $('#txtSPK').val();

    $('#addJobsForm').on('submit', function(e) {
        e.preventDefault();

        var spk = $('#txtSPK').val();
        var id = $('#txtID').val();
        var judul = $('#txtJudul').val();
        var type = $('#txtType option:selected').val();
        var location = $('#txtLocation option:selected').val();

        $.ajax({
            url: 'php/ajx/crudJob.php?type=addJudul',
            type: 'post',
            data: 'spk=' + spk + '&judul=' + judul + '&id=' + id + '&type=' + type + '&location=' + location,

            success: function(msg) {
                if (msg != '') {
                    alert(msg);
                    window.location.reload();
                    $('#formJudul #txtJudul').val('');
                    $("#listPanel").load("?p=add-list-job&name=" + spk + " #listPanel");
                    $("#formJudul1").load("?p=add-list-job&name=" + spk + " #formJudul1");
                }

            }
        });
    });

    $('#formJudulMPO').on('submit', function(event) {
        event.preventDefault();

        if ($(this).parsley().validate()) {

            var spk = $('#txtSPK').val();
            var id = $('#txtID').val();
            var type = $('#txtType option:selected').val();
            var judul = $('#txtJudul option:selected').val();
            var location = $('#txtLocation option:selected').val();

            $.ajax({
                url: 'php/ajx/crudJob.php?type=addJudul',
                type: 'post',
                data: 'spk=' + spk + '&judul=' + judul + '&id=' + id + '&type=' + type + '&location=' + location,

                success: function(msg) {
                    if (msg != '') {
                        alert(msg);
                        window.location.reload();

                        $("#listPanel").load("?p=add-list-job&name=" + spk + " #listPanel");
                        $("#formJudulMPO").load("?p=add-list-job&name=" + spk + " #formJudulMPO");
                    }

                }
            });
        } else {
            alert('System Error');
        }
    });

    $('#listPanel').on('click', '.tambahDetail', function() {
        var id = $(this).data('id');
        var admin = $(this).data('admin');


        $('#inputDetail').load('php/ajx/addDetailJobs.php?id=' + id + '&admin=' + admin);
    })

    $('#listPanel').on('click', '.tambahDetailMPO', function() {
        var id = $(this).data('id');
        var admin = $(this).data('admin');


        $('#inputDetail').load('php/ajx/addDetailJobs.php?id=' + id + '&admin=' + admin);
    })

    $('#inputDetail').on('submit', '#detailJob', function(event) {
        event.preventDefault();

        if ($(this).parsley().validate()) {
            var spk = $('#txtSPK').val();
            var kode = $('#txtKodeDetail').val();
            var admin = $('#txtAdmin').val();
            var kegiatan = $('#txtKegiatan').val();
            var deskripsi = $('#txtDeskripsi').val();
            var keterangan = $('#txtKeterangan').val();

            // alert(spk + kode + admin + kegiatan + deskripsi + keterangan);

            $.ajax({
                url: 'php/ajx/crudJob.php?type=addDetail',
                type: 'post',
                data: 'kode=' + kode + '&admin=' + admin + '&kegiatan=' + kegiatan + '&deskripsi=' + deskripsi + '&keterangan=' + keterangan,

                success: function(msg) {
                    if (msg != '') {
                        alert(msg);
                        location.reload();
                        $("#listPanel").load("?p=add-list-job&name=" + spk + " #listPanel");
                        $('#detailJob').load("?p=add-list-job&name=" + spk + " #detailJob");
                        $('#tableDetail').load("?p=add-list-job&name=" + spk + " #tableDetail");
                    }

                }
            })

        } else {
            alert('Mohon di perhatikan!');
        }
    });

    $('#listPanel').on('click', '.removeDetail', function() {
        var id = $(this).data('id');

        $.ajax({
            url: 'php/ajx/crudJob.php?type=deleteDetail',
            type: 'post',
            data: 'id=' + id,

            success: function(msg) {
                if (msg != '') {
                    alert(msg);
                    location.reload();

                    $("#listPanel").load("?p=add-list-job&name=" + spk + " #listPanel");
                    $('#detailJob').load("?p=add-list-job&name=" + spk + " #detailJob");
                }

            }
        })
    });

    $('#listPanel').on('click', '.removeTitle', function() {
        var id = $(this).data('id');

        $.ajax({
            url: 'php/ajx/crudJob.php?type=deleteTitle',
            type: 'post',
            data: 'id=' + id,

            success: function(msg) {
                if (msg != '') {
                    alert(msg);
                    location.reload();
                    $("#listPanel").load("?p=add-list-job&name=" + spk + " #listPanel");
                    $('#detailJob').load("?p=add-list-job&name=" + spk + " #detailJob");
                }

            }
        })
    });



    $('#listPanel').on('click', '.finishJobs', function() {
        var id = $(this).data('spk');


        $.ajax({
            url: 'php/ajx/crudJob.php?type=finishJobs',
            type: 'post',
            data: 'id=' + id,

            success: function(msg) {
                if (msg != '') {
                    window.location.href = '?p=entry-data';
                }

            }
        })
    });

    $('#requestKebutuhanPerusahaanMPO').hide();
    $('#listKebutuhanPerusahaanMPO').hide();
    $('#tambahJabatanKaryawan').on('submit', function(e) {
        e.preventDefault();

        if ($(this).parsley().validate()) {

            var kode = $('#kodeListKaryawan').val();
            var idKtp = $('#namaKaryawanPR option:selected').val();
            var idJabatan = $('#listJabatan option:selected').val();

            $.ajax({
                url: 'php/ajx/CRUD.php?type=addJabatan',
                type: 'post',
                data: 'kode=' + kode + '&ktp=' + idKtp + '&jabatan=' + idJabatan,

                success: function(msg) {
                    if (msg != '') {
                        alert(msg);
                        location.reload();
                    }

                }
            })
        } else {

        }
    });

    $('#formRequestKebutuhan').on('submit', function(e) {
        e.preventDefault();

        var perusahaan = $('#listPerusahaan option:selected').val();
        var kebutuhan = $('#listKebutuhan option:selected').val();

        if ($(this).parsley().validate()) {

            if (kebutuhan === 'MPO01') {
                $('#txtPerusahaan').val(perusahaan);
            } else {

            }

        } else {
            var btn = $('.buttooom').html('try again');
            btn.removeClass('btn-primary');
            btn.addClass('btn-danger');
        }
    });

    $('#adminStatus').on('click', '.disableAdmin', function() {

        var id = $(this).data('username');

        $.ajax({
            url: 'php/ajx/CRUD.php?type=disableAdmin',
            type: 'post',
            data: 'kode=' + id,

            success: function(msg) {
                if (msg != '') {
                    alert(msg);
                    location.reload();
                }

            }

        });
    })
    $('#adminStatus').on('click', '.enableAdmin', function() {

        var id = $(this).data('username');

        $.ajax({
            url: 'php/ajx/CRUD.php?type=enableAdmin',
            type: 'post',
            data: 'kode=' + id,

            success: function(msg) {
                if (msg != '') {
                    alert(msg);
                    location.reload();
                }

            }

        });
    })

    $('#adminStatus').on('click', '.resetPasswordAdmin', function() {

        var id = $(this).data('id');
        //alert(id);
        $.ajax({
            url: 'php/ajx/CRUD.php?type=resetPasswordAdmin',
            type: 'post',
            data: 'username=' + id,

            success: function(msg) {
                if (msg != '') {
                    alert(msg);
                    location.reload();
                }

            }

        });
    });

    $('#optionFilter').on('change', function() {
        var id = $(this).find('option:selected').val();
        if (id == 'posisi') {
            $('#jobsListFilter').removeClass('hidden');
            $('#locationListFilter').addClass('hidden');
            $('#kotaListFilter').addClass('hidden');
            $('#shcListFilter').addClass('hidden');
            $.ajax({
                url: 'php/ajx/CRUD.php?type=listJobs',
                type: 'post',
                data: 'id=' + id,

                success: function(msg) {
                    console.log(msg);
                    // $('#tempatKerja').empty();
                    $('#kotaList').removeAttr('required');
                    $('#shcList').removeAttr('required');
                    $('#provinsiList').removeAttr('required');
                    $('.js-example-basic-single').select2();
                    $.each(msg, function(index, value) {
                        $('#jobsList').append('<option value="' + value.kd_pekerjaan + '">' + value.nama_pekerjaan + '</option>');
                    })
                }
            });
        } else if (id == 'locations') {
            $('#jobsListFilter').addClass('hidden');
            $('#shcListFilter').addClass('hidden');
            $.ajax({
                url: 'php/ajx/CRUD.php?type=prov',
                type: 'post',
                data: 'id=' + id,

                success: function(msg) {
                    console.log(msg);
                    $('#locationListFilter').removeClass('hidden');
                    $('#shcList').removeAttr('required');
                    $('.js-example-basic-single').select2();
                    $('#jobsList').removeAttr('required');
                    $.each(msg, function(index, value) {
                        $('#provinsiList').append('<option value="' + value.id + '">' + value.name + '</option>');
                    })
                }
            });
        } else if (id == 'pendidikan') {
            $('#shcListFilter').removeClass('hidden');
            $('#locationListFilter').addClass('hidden');
            $('#jobsListFilter').addClass('hidden');
            $('#jobsList').removeAttr('required');
            $('#provinsiList').removeAttr('required');
            $('#kotaList').removeAttr('required');
        } else {

            $('#jobsList').removeAttr('required');
            $('#kotaList').removeAttr('required');
            $('#provinsiList').removeAttr('required');

            if ($('#jobsListFilter').hasClass('hidden')) {

            } else {
                $('#jobsListFilter').addClass('hidden');


            }
        }
    });

    $('#provinsiList').on('change', function(e) {
        e.preventDefault();
        var id = $(this).find('option:selected').val();
        $('#kotaList').empty();
        $.ajax({
            url: 'php/ajx/CRUD.php?type=provinsi',
            type: 'post',
            data: 'id=' + id,

            success: function(msg) {
                console.log(msg);
                $('#kotaListFilter').removeClass('hidden');
                $('.js-example-basic-single').select2();
                $('#jobsList').removeAttr('required');
                $.each(msg, function(index, value) {
                    $('#kotaList').append('<option value="' + value.id + '">' + value.name + '</option>');
                })
            }
        });
    })

    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        var fil = $('#optionFilter option:selected').val();


        if (fil == 'locations') {
            gen = $('#kotaList option:selected').val();
        } else if (fil == 'pendidikan') {
            gen = $('#shcList option:selected').val();
        } else if (fil == 'posisi') {
            gen = $('#jobsList option:selected').val();
        }

        var jobs
        window.location.href = '?p=calon-karyawan&' + fil + '=' + gen;
    });


})