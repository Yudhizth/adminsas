$(document).ready(function () {

    var formLoker = $('#form-loker').hide();

    //var loker = $('#form-loker').hide().load('php/ajx/form-loker.php').fadeIn(1500);

    $('#listLoker').on('click', '.editLoker', function () {
        var id = $(this).data('id');
        var judul = $(this).data('judul');
        var desc = $(this).data('desc');
        var req = $(this).data('req');
        var salary = $(this).data('salary');
        var area = $(this).data('area');
        var pengalaman = $(this).data('pengalaman');

        formLoker.show('fast');
        $('#conten-loker').hide('fast');

        $('#txtID').val(id);
        $('#txtJudul').val(judul);
        CKEDITOR.instances.jobsDesc.setData( desc,    function()
        {
            this.checkDirty();  // true
        });
        CKEDITOR.instances.reqLoker.setData( req,    function()
        {
            this.checkDirty();  // true
        });
        //$('#jobsDesc').val(desc);
        //$('#reqLoker').val(req);
        $('#txtSalary').val(salary);
        $('#txtArea').val(area);
        $('#txtPengalaman option:selected').val(pengalaman);

    });

    $('#conten-loker').on('click', '.addLoker', function () {
        formLoker.show('slow');
        $('#conten-loker').hide('slow');
    })

    CKEDITOR.editorConfig = function( config ) {
        config.toolbarGroups = [
            { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
            { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
            { name: 'forms', groups: [ 'forms' ] },
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
            { name: 'links', groups: [ 'links' ] },
            { name: 'insert', groups: [ 'insert' ] },
            { name: 'styles', groups: [ 'styles' ] },
            { name: 'colors', groups: [ 'colors' ] },
            { name: 'tools', groups: [ 'tools' ] },
            { name: 'others', groups: [ 'others' ] },
            { name: 'about', groups: [ 'about' ] }
        ];
    };
    CKEDITOR.replace( 'reqLoker' );
    CKEDITOR.replace( 'jobsDesc' );
})