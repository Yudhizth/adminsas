$(document).ready(function () {


    $('#formListInterview').on('submit', '#searchInterviewList', function (e) {
        e.preventDefault();

        var type = $('#typeFilterInterview option:selected').val();
        var text = $('#txtInterviewFilter').val();

        $('#listInterview').hide().load('php/ajx/listInterview.php?type=intreview&tipe='+type+'&filter='+text).fadeIn(500);
    })
});