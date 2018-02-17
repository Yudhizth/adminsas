function tambahAbsen(id, star, pause, cont, finish, tanggal, ket) {

    $.ajax({
        url : 'php/ajx/CRUD.php?type=addAbsen',
        type: 'post',
        data: 'ktp='+id+'&start='+star+'&break='+pause+'&continue='+cont+'&finish='+finish+'&tgl='+tanggal+'&ket='+ket,

        success: function (msg) {
            if(msg != ""){
                alert(msg);
                location.reload();
            }
        }

    });
    
}
$(document).ready(function () {

    var range = $('#detailAbsen').hide();

    $('#listAbsen').on('click', '.viewRange', function () {
        var id = $(this).data('ktp');
        var depan = $(this).data('depan');
        var belakang = $(this).data('belakang');


        $('#txtKtp').val(id);
        $('#namaDepan').val(depan);
        $('#namaBelakang').val(belakang);

        range.show(400);
    });
    
    $('#fetchAbsen').on('click', '.showAbsen', function () {
        var dari = $('#single_cal1').val();
        var sampai = $('#single_cal2').val();

        var id = $('#txtKtp').val();

        $('#absen').hide();
        $('#hasilAbsen').load('php/ajx/detailAbsen.php?ktp='+id+'&dari='+dari+'&sampai='+sampai);
    })
    //
    // $('#listAbsen').on('submit', '.fetchAbsen', function () {
    //     var id = $('#txtKtp').val();
    //     var start = $('#txtStart').val();
    //     var ends = $('#txtEnds').val();
    //
    //     alert(id);
    //     if(start === "" && ends === ""){
    //         return false;
    //     }
    // })

    var tanggal = new Date().toJSON().slice(0, 10).replace(/-/g, '-');
    $('#absenKaryawan').fullCalendar({
        header: {
            left: 'prev, next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
        defaultDate: +tanggal,
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        selectable: true,
        selectHelper: true,
        hasTime: true,
        select: function (start, end) {

            $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
            $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
            $('#ModalAdd').modal('show');
        },
        eventRender: function (event, element) {
            element.bind('dblclick', function () {
                $('#ModalEdit #id').val(event.id);
                $('#ModalEdit #title').val(event.title);
                $('#ModalEdit #color').val(event.color);
                $('#ModalEdit').modal('show');
            });
        },
        eventDrop: function (event, delta, revertFunc) { // si changement de position

            edit(event);

        },
        eventResize: function (event, dayDelta, minuteDelta, revertFunc) { // si changement de longueur

            edit(event);

        },
        events: [
            {
                title: 'event 1',
                start: '2015-01-04',
                end: '2015-01-06',
                color: 'tomato'
            }
        ]
    });
})