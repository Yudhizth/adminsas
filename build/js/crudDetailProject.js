$(document).ready(function() {

    $('.js-example-basic-multiple').select2();
    var fixedTime = $('#fixedTime').hide();
    var flexiTime = $('#flexibleTime').hide();

    $('#timeType').on('change', function() {
        id = $(this).val();
        $('#typeTime').val(id);
        if (id == 'fix') {

            flexiTime.hide("drop", { direction: "right" }, 500);
            fixedTime.show(500);
        } else if (id == 'flex') {
            fixedTime.hide("drop", { direction: "right" }, 500);
            flexiTime.show(500);
        } else {
            fixedTime.hide("drop", { direction: "down" }, "slow");
            flexiTime.hide("drop", { direction: "down" }, "slow");
        }

    });


    $('input.timepicker').timepicker({
        timeFormat: 'H:mm',
        interval: 5,
        minTime: '01',
        maxTime: '11:30pm',
        defaultTime: '00',
        startTime: '01:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });

    $('#kontrakStart').daterangepicker({
        locale: {
            format: 'YYYY/MM/DD'
        }
    });

    $('#detailMPO').on('click', '.saveGaji', function() {
        var id = $(this).data('id');
        var gaji = $('#' + id).val();

        if (gaji == '') {
            alert('Not Null!');
        } else {
            $.ajax({
                url: 'php/ajx/CRUD.php?type=saveGaji',
                type: 'post',
                data: 'id=' + id + '&gaji=' + gaji,

                success: function(msg) {
                    if (msg != '') {
                        alert(msg);
                    }

                }
            })
        }
    });

    $('#txt_provinsi').on('change', function(e) {
        e.preventDefault();

        var id = $(this).val();

        $.ajax({
            url: 'php/ajx/CRUD.php?type=provinsi',
            type: 'post',
            data: 'id=' + id,

            success: function(msg) {
                console.log(msg);
                // $('#tempatKerja').empty();
                $('#tempatKerja').prop('disabled', false);
                $.each(msg, function(index, value) {
                    $('#tempatKerja').append('<option value="' + value.id + '" data-id="' + value.id + '">' + value.name + '</option>');
                })

                // $('#kotaReg').select2({
                //     theme: 'bootstrap4',
                //     placeholder: "Select an option",
                //     allowClear: true
                // });

            }
        });

    });


})