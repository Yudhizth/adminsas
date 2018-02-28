$(document).ready(function () {


    $('#formListPsikotes').on('submit', '#searchPsikotesList', function (e) {
        e.preventDefault();

        var type = $('#typeFilterPsikotes option:selected').val();
        var text = $('#txtPsikotesFilter').val();

        $('#listUjianPsikotes').hide().fadeOut(1000);
        $('#listPsikotes').hide().load('php/ajx/listPsikotes.php?type=psikotes&tipe='+type+'&filter='+text).fadeIn(800);
    })
});