$(document).ready(function(){
   var fixedTime = $('#fixedTime').hide();
   var flexiTime = $('#flexibleTime').hide();

    $('#timeType').on('change', function () {
       id = $(this).val();
        $('#typeTime').val(+id);
       if(id == 1){

           flexiTime.hide( "drop", { direction: "right" }, 500 );
            fixedTime.show(500);
       }
       else if(id == 2){
           fixedTime.hide( "drop", { direction: "right" }, 500 );
            flexiTime.show(500);
        }
        else{
           fixedTime.hide( "drop", { direction: "down" }, "slow" );
           flexiTime.hide( "drop", { direction: "down" }, "slow" );
       }

    });
})