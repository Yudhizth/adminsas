
<!-- footer content -->
        </div>
        <footer>
          <div class="pull-right">
            <span class="fa fa-copyright"></span> <a href="www.sinergiadhikarya.co.id">Website</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
<!-- jQuery -->
    <script src="vendors/js/jquery-1.10.2.js"></script>
    <script src="vendors/js/jquery-ui.js"></script>
    <!-- CKeditor -->
    <script src="vendors/ckeditor/ckeditor.js"></script>
    <script src="vendors/ckeditor/styles.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="vendors/DataTables/media/js/jquery.dataTables.min.js"></script>
    <script src="vendors/DataTables/media/js/dataTables.bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="vendors/Flot/jquery.flot.js"></script>
    <script src="vendors/Flot/jquery.flot.pie.js"></script>
    <script src="vendors/Flot/jquery.flot.time.js"></script>
    <script src="vendors/Flot/jquery.flot.stack.js"></script>
    <script src="vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="vendors/DateJS/build/date.js"></script>
    <!-- smart-wizart-form -->
    <script src="vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
    <!-- JQVMap -->
    <script src="vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="vendors/google-code-prettify/src/prettify.js"></script>
    <script src="vendors/parsleyjs/dist/parsley.js"></script>

<script src="vendors/echarts/dist/echarts.min.js"></script>

    <!-- Custom Theme Scripts --> 
    <script src="build/js/custom.js"></script>
 <script src="build/js/crud.js"></script>
<script src="build/js/crudDetailProject.js"></script>
<script src="build/js/crudKaryawanProject.js"></script>
<script src="build/js/crudLembur.js"></script>
<script src="build/js/customOwn.js"></script>

    <script type="text/javascript">
    $(document).on("click", ".tampilData", function(){
      $("#hapusID").text($(this).data("id"));
      $("#tanggal").text($(this).data("cd"));
      $("#nama").text($(this).data("nama"));
      $("#pesan").html($(this).data("ps"));
      $("#listKanan").fadeIn(700);
      $("#listKanan").show();
    });

    $(document).on("click", "#close", function(){
      $("#listKanan").toggle("slide");
      $("#listKanan").hide();
    });

    // $("#compose").click(function(){
    //     $("#composeNew").hide().load("php/ajx/compose_new_push.php").fadeIn(700);
    // });

    $(document).on('click','#compose', function(){
        $("#composeNew").show();
    });

    $(function() {
        function split( val ) {
            return val.split( /,\s*/ );
        }
        function extractLast( term ) {
            return split( term ).pop();
        }
        
        $( "#kepada" ).bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).autocomplete( "instance" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete({
            minLength: 1,
            source: function( request, response ) {
                // delegate back to autocomplete, but extract the last term
                $.getJSON("php/ajx/push_list_karyawan.php", { term : extractLast( request.term )},response);
            },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            select: function( event, ui ) {
                var terms = split( this.value );
                // remove the current input
                terms.pop();
                // add the selected item
                terms.push( ui.item.value );
                // add placeholder to get the comma-and-space at the end
                // terms.push(" ");
                this.value = terms;
                return false;
            }
        });
    });
     $(document).on('click', '.daftar', function(){
        var id = $(this).data('id');
        

          $.ajax({

            url: 'php/ajx/daftar-karyawan.php',
            type: 'POST',
            dataType: 'text',
            data: {
              id: id
            }, 
            success: function(data){
              alert('' +data+ '')
              location.reload();
            }
          });

     });
    $(document).on('click', '.lulus', function(){
        var id = $(this).data('id');
        var st = $(this).data('st');
        var kode = $(this).data('kode');

        $.ajax({

            url: 'php/ajx/add-nilai.php',
            type: 'POST',
            dataType: 'text',
            data: {
                id: id,
                st: st,
                kode: kode
            },
            success: function(data){
                alert('' +data+ '')
                location.href='?p=soal-psikolog';
            }
        });

    });
    $(document).on('click', '.gagal', function(){
        var id = $(this).data('id');
        var st = $(this).data('st');
        var kode = $(this).data('kode');

        $.ajax({

            url: 'php/ajx/add-nilai.php',
            type: 'POST',
            dataType: 'text',
            data: {
                id: id,
                st: st,
                kode: kode

            },
            success: function(data){
                alert('' +data+ '')
                location.href='?p=soal-psikolog';
            }
        });

    });
     $(document).on('click', '.addKaryawan', function(){
        var nik = $(this).data('nik');
        var kode = $(this).data('kode');

          $.ajax({

            url: 'php/ajx/add-karyawan.php',
            type: 'POST',
            dataType: 'text',
            data: {nik: nik, kode: kode},

            success: function(data){
              alert('' +data+ '')
              location.reload();
            }
          });

     });
    $(document).on('click', '.generateKode', function(){
        var id = $(this).data('id');
        alert(id);
        // $.ajax({

        //     url: 'php/ajx/insertKode.php',
        //     type: 'POST',
        //     dataType: 'text',
        //     data: {id : id},

        //     success: function(data){
        //         alert('' +data+ '')
        //         location.reload();
        //     }
        // });

    });
       /* Custom filtering function which will search data in column four between two values */
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var min = parseInt( $('#min').val(), 10 );
                var max = parseInt( $('#max').val(), 10 );
                var age = parseFloat( data[6] ) || 0; // use data for the age column
        
                if ( ( isNaN( min ) && isNaN( max ) ) ||
                    ( isNaN( min ) && age <= max ) ||
                    ( min <= age   && isNaN( max ) ) ||
                    ( min <= age   && age <= max ) )
                {
                    return true;
                }
                return false;
            }
        );
        
        function filterGlobal () {
    $('#example').DataTable().search(
        $('#global_filter').val('option:selected')
    ).draw();
}

    $(document).ready(function() {
                var table = $('#list_pelamar').DataTable({
                        "scrollY": "500px",
                        "paging": true
                    });

                // Event listener to the two range filtering inputs to redraw on input
                $('#min, #max').keyup( function() {
                    table.draw();
                });
                
                
                $('.dataTables_filter input').unbind().bind('keyup', function() {
                  var colIndex = document.querySelector('#select').selectedIndex;
                  table.column( colIndex).search( this.value ).draw();
                });
                
                $('select.global_filter').on( 'keyup click', function () {
                    filterGlobal();
                });

                $('a.toggle-vis').on( 'click', function (e) {
                e.preventDefault();
        
                // Get the column API object
                var column = table.column( $(this).attr('data-column') );
        
                // Toggle the visibility
                column.visible( ! column.visible());
                
        });
        
    });
    </script>

	
  </body>
</html>
