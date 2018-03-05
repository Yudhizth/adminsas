<?php
/**
 * Created by PhpStorm.
 * User: small-project
 * Date: 05/03/2018
 * Time: 13.12
 */

$id = $_GET['kode'];
if(isset($_POST['addMap'])){
    $a = $_POST['mapSPK'];
    $b = $_POST['mapLabel'];
    $c = $_POST['mapLat'];
    $d = $_POST['mapLng'];
    $e = $_POST['mapLocation'];

    if(empty($c)){
        $error =  "Input terlebih dahulu koordinatnya";
    }else{
        //    $f = array( $a, $b, $c, $d, $e);
//
//    echo "<br><pre>";
//
//    print_r($f);
//
//    echo "</pre>";

        $sql = "INSERT INTO tb_koordinat_perusahaan (nomor_kontrak, label, lat, lng, location, kode_admin) VALUES (:a, :b, :c, :d, :e, :f)";

        $stmt = $config->runQuery($sql);
        $stmt->execute(array(
            ':a'    => $a,
            ':b'    => $b,
            ':c'    => $c,
            ':d'    => $d,
            ':e'    => $e,
            ':f'    => $admin_id
        ));

        if($stmt){
            echo "<script>
        alert('Koordinat berhasil ditambahkan!');
        window.location.href='?p=detailProject&id=".$a." ';
        </script>";
        }else{
            echo "error";
        }
    }
}
?>
<style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
        height: 100%;
    }
    /* Optional: Makes the sample page fill the window. */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    .pac-container {
        font-family: Roboto;
    }

    #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
    }

    #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Detail Project</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

               <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 col-sm-offset-3">

                   <?php if(isset($error)){ ?>
                       <div class="alert alert-danger alert-dismissible fade in" role="alert">
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                           </button>
                           <strong>ERROR!</strong> <?=$error?>
                       </div>
                   <?php } ?>

                   <form id="form-map" data-parsley-validate="" method="post" novalidate="">
                       <label for="fullname">Nomor SPK:</label>
                       <input type="text" id="mapSPK" class="form-control" name="mapSPK" value="<?=$id?>" readonly>
                        <br>
                       <label for="email">Label Map:</label>
                       <input type="text" id="mapLabel" class="form-control" name="mapLabel" required="">
                       <input type="hidden" id="mapLat" class="form-control" name="mapLat" required="">
                       <input type="hidden" id="mapLng" class="form-control" name="mapLng" required="">
                       <input type="hidden" id="mapLocation" class="form-control" name="mapLocation" required="">


                       </p>
                       <p>

                           <button class="btn btn-primary btn-block" type="submit" name="addMap">SUBMIT MAP</button>

                       </p>
                   </form>

                   <br>

                   <input id="pac-input" class="controls" type="text"
                          placeholder="Enter a location">
                   <div id="type-selector" class="controls">
                       <input type="radio" name="type" id="changetype-all" checked="checked">
                       <label for="changetype-all">All</label>
                       <input type="radio" name="type" id="changetype-establishment">
                       <label for="changetype-establishment">Establishments</label>

                       <input type="radio" name="type" id="changetype-address">
                       <label for="changetype-address">Addresses</label>

                       <input type="radio" name="type" id="changetype-geocode">
                       <label for="changetype-geocode">Geocodes</label>

                   </div>
                   <div id="map" style="height: 400px; width: 600px"></div>

                   <script>
                       // This example requires the Places library. Include the libraries=places
                       // parameter when you first load the API. For example:
                       // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

                       function initMap() {
                           var map = new google.maps.Map(document.getElementById('map'), {
                               center: {lat: -6.189229300000001, lng: 106.80126910000001},
                               zoom: 13
                           });
                           var input = /** @type {!HTMLInputElement} */(
                               document.getElementById('pac-input'));

                           var types = document.getElementById('type-selector');
                           map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                           map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

                           var autocomplete = new google.maps.places.Autocomplete(input);
                           autocomplete.bindTo('bounds', map);

                           var infowindow = new google.maps.InfoWindow();
                           var marker = new google.maps.Marker({
                               map: map,
                               anchorPoint: new google.maps.Point(0, -29)
                           });

                           autocomplete.addListener('place_changed', function() {
                               infowindow.close();
                               marker.setVisible(false);
                               var place = autocomplete.getPlace();


                               var name_lat = place.geometry.location.lat();
                               var name_lng = place.geometry.location.lng();
                               var Location = place.formatted_address;

                               $('#mapLat').val(name_lat);
                               $('#mapLng').val(name_lng);
                               var LatLng = place.geometry.location.toJSON();
                               console.log(LatLng);
                               $('#mapLocation').val(Location);


                               if (!place.geometry) {
                                   // User entered the name of a Place that was not suggested and
                                   // pressed the Enter key, or the Place Details request failed.
                                   window.alert("No details available for input: '" + place.name + "'");
                                   return;
                               }

                               // If the place has a geometry, then present it on a map.
                               if (place.geometry.viewport) {
                                   map.fitBounds(place.geometry.viewport);
                               } else {
                                   map.setCenter(place.geometry.location);
                                   map.setZoom(17);  // Why 17? Because it looks good.
                               }
                               marker.setIcon(/** @type {google.maps.Icon} */({
                                   url: place.icon,
                                   size: new google.maps.Size(71, 71),
                                   origin: new google.maps.Point(0, 0),
                                   anchor: new google.maps.Point(17, 34),
                                   scaledSize: new google.maps.Size(35, 35)
                               }));
                               marker.setPosition(place.geometry.location);
                               marker.setVisible(true);

                               var address = '';
                               if (place.address_components) {
                                   address = [
                                       (place.address_components[0] && place.address_components[0].short_name || ''),
                                       (place.address_components[1] && place.address_components[1].short_name || ''),
                                       (place.address_components[2] && place.address_components[2].short_name || '')
                                   ].join(' ');
                               }

                               infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                               infowindow.open(map, marker);
                           });

                           // Sets a listener on a radio button to change the filter type on Places
                           // Autocomplete.
                           function setupClickListener(id, types) {
                               var radioButton = document.getElementById(id);
                               radioButton.addEventListener('click', function() {
                                   autocomplete.setTypes(types);
                               });
                           }

                           setupClickListener('changetype-all', []);
                           setupClickListener('changetype-address', ['address']);
                           setupClickListener('changetype-establishment', ['establishment']);
                           setupClickListener('changetype-geocode', ['geocode']);
                       }
                   </script>
                   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1oiLMSeZ-HV2Yy-oqjdDdme2WmTtOWVc&libraries=places&callback=initMap"
                           async defer></script>
               </div>
            </div>
        </div>
    </div>
</div>
