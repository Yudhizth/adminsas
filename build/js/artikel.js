function delArtikel(id) {
    if (!confirm('Are you sure want to delete this?')) {
        return false;
    } else {
        $.ajax({
            url: 'php/ajx/actArtikel.php?type=delArtikel',
            method: 'post',
            data: { data: id },

            success: function(msg) {
                location.reload();
                alert(msg);
            }
        })
    }

}
$(document).ready(function () {

    // CKEDITOR.instances.isiArtikel.setData( req,    function()
    // {
    //     this.checkDirty();  // true
    // });

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
    CKEDITOR.replace( 'isiArtikel' );
})