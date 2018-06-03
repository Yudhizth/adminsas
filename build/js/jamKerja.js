$(document).on('submit', '#formKontrak', function (e) {
    e.preventDefault();

    var oForm = $(this);
    var formId = oForm.attr("id");
    var id = oForm.find("input").first().val();
    var suIn = $('#suIn'+id).val();
    var suOut = $('#suOut'+id).val();
    var moIn = $('#moIn'+id).val();
    var moOut = $('#moOut'+id).val();
    var tuIn = $('#tuIn'+id).val();
    var tuOut = $('#tuOut'+id).val();
    var weIn = $('#weIn'+id).val();
    var weOut = $('#weOut'+id).val();
    var thIn = $('#thIn'+id).val();
    var thOut = $('#thOut'+id).val();
    var frIn = $('#frIn'+id).val();
    var frOut = $('#frOut'+id).val();
    var saIn = $('#saIn'+id).val();
    var saOut = $('#saOut'+id).val();
    var spk = $('#nomorKontrak').val();


    var jam = {
        absen_in: [
            {minggu: suIn, senin: moIn, selasa: tuIn, rabu: weIn, kamis: thIn, jumat: frIn, sabtu: saIn}
        ],
        absen_out: [
            {minggu: suOut, senin: moOut, selasa: tuOut, rabu: weOut, kamis: thOut, jumat: frOut, sabtu: saOut}
        ]

    };
    var absen = JSON.stringify(jam);

    $.ajax({
        type: 'post',
        url: 'php/ajx/jamKerja.php?type=kontrak',
        data: { spk: spk, lokasi: id, jamKerja: absen },
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);
             alert(data);
            //location.reload();
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    });
})
$(document).on("submit", "#timeShift", function (e) {
    e.preventDefault();
    var oForm = $(this);
    var formId = oForm.attr("id");
    var id = oForm.find("input").first().val();
    var kontrak = $('#nomorKontrak').val();
    var code = $('#shiftCode').val();

    var total = $('#totalShift').val();

    var jamKerja = [];

    for (i = 0; i <= total; i++){
        var suIn = $('#suIn'+id+'_'+i).val();
        var suOut = $('#suOut'+id+'_'+i).val();
        var moIn = $('#moIn'+id+'_'+i).val();
        var moOut = $('#moOut'+id+'_'+i).val();
        var tuIn = $('#tuIn'+id+'_'+i).val();
        var tuOut = $('#tuOut'+id+'_'+i).val();
        var weIn = $('#weIn'+id+'_'+i).val();
        var weOut = $('#weOut'+id+'_'+i).val();
        var thIn = $('#thIn'+id+'_'+i).val();
        var thOut = $('#thOut'+id+'_'+i).val();
        var frIn = $('#frIn'+id+'_'+i).val();
        var frOut = $('#frOut'+id+'_'+i).val();
        var saIn = $('#saIn'+id+'_'+i).val();
        var saOut = $('#saOut'+id+'_'+i).val();

        var shift = 'shift_'+i;

        // jamKerja[i] = ['in_shift_'+i , suIn , moIn, tuIn, weIn, thIn, frIn, saIn, 'out_shift_'+i, suOut, moOut, tuOut, weOut, thOut, frOut, saOut];
        // jamKerja[i] =[{ shift_in: i, su: suIn, mo: moIn, tu: tuIn, we: weIn, th: thIn, fr: frIn, sa: saIn },{ shift_out: i, su: suOut, mo: moOut, tu: tuOut, we: weOut, th: thOut, fr: frOut, sa: saOut }];
        jamKerja[i] = {
            absen_in: {su: suIn, mo: moIn, tu: tuIn, we: weIn, th: thIn, fr: frIn, sa: saIn},
            absen_out:{su: suOut, mo: moOut, tu: tuOut, we: weOut, th: thOut, fr: frOut, sa: saOut}
        };
    }
    var jamFix = JSON.stringify(jamKerja);


    $.ajax({
        type: 'post',
        url: 'php/ajx/jamKerja.php?type=shiftTime',
        data: { nomor_kontrak: kontrak, lokasi: id, jamKerja: jamFix, total_shift: total, shift_number: code},
        success: function (data) {
            console.log(data);
            
            alert(data);
            //location.reload();
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    });
    //alert(jamKerja);
    // alert(formId + '_' + id + '_' + kontrak + '_' + code + '_' + suIn+'_'+suOut + moIn + moOut + tuIn + tuOut + weIn + weOut + thIn + thOut + frIn + frOut + saIn + saOut);

})
$(document).on("submit", "#formFreelance", function (e) {
    e.preventDefault();
    var oForm = $(this);
    var formId = oForm.attr("id");
    var id = oForm.find("input").first().val();
    var su = $('#minggu'+id).val();
    var mo = $('#senin'+id).val();
    var tu = $('#selasa'+id).val();
    var we = $('#rabu'+id).val();
    var th = $('#kamis'+id).val();
    var fr = $('#jumat'+id).val();
    var sa = $('#sabtu'+id).val();
    var form = $('#typeTimes').val();
    var spk = $('#nomorKontrak').val();

    var jam = {minggu: su, senin: mo, selasa: tu, rabu: we, kamis: th, jumat: fr, sabtu: sa};
    var jamKerja = JSON.stringify(jam);


    $.ajax({
        type: 'post',
        url: 'php/ajx/jamKerja.php?type=freelance',
        data: {kota: id, type_time: form, nomor_kontrak: spk, jamKerja: jamKerja },
        success: function (data) {
            console.log('Submission was successful.');
            console.log(data);
             alert(data);
            //location.reload();
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    });
    // return false;
})


$(document).ready(function () {

    $('#scheduleList').on('click', '.doneSchedule', function (e) {
        e.preventDefault();
        var id = $(this).data('type');
        if(!confirm('Are you sure want done with it?')){
            return false;
        }else{
            $.ajax({
                type: 'post',
                url: 'php/ajx/jamKerja.php?type=doneSchedule',
                data: { id: id },
                success: function (data) {
                    window.location.href = '?p=entry-data';
                },
                error: function (data) {
                    alert(data);
                },
            });
        }
    })
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
    $('#formShiftTimes').on('submit', function (e) {
        e.preventDefault();
        var shift = $('#countShift').val();
        var id = $('#nomorKontrak').val();

        $.ajax({
            type: 'post',
            url: 'php/ajx/jamKerja.php?type=Shift',
            data: { nomor_kontrak: id, shifts: shift},
            success: function (data) {
                console.log('Submission formShift was successful.');
                // alert(data);
                location.reload();
            },
            error: function (data) {
                console.log('An error occurred.');
            },
        });
    })
})