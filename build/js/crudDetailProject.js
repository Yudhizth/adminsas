$(document).ready(function(){
   var fixedTime = $('#fixedTime').hide();
   var flexiTime = $('#flexibleTime').hide();

    $('#timeType').on('change', function () {
       id = $(this).val();
        $('#typeTime').val(id);
       if(id == 'fix'){

           flexiTime.hide( "drop", { direction: "right" }, 500 );
            fixedTime.show(500);
       }
       else if(id == 'flex'){
           fixedTime.hide( "drop", { direction: "right" }, 500 );
            flexiTime.show(500);
        }
        else{
           fixedTime.hide( "drop", { direction: "down" }, "slow" );
           flexiTime.hide( "drop", { direction: "down" }, "slow" );
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
            format: 'DD/MM/YYYY'
        }
    });


})
