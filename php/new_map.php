<?php
$id = $_GET['spk'];
$kode = $_GET['kode'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <style>
        .card-block{
            padding: 0.1rem;
        }

        .input-group {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -webkit-box-align: stretch;
            -ms-flex-align: stretch;
            align-items: stretch;
            width: 100%;
        }
        *, ::after, ::before {
            box-sizing: border-box;
        }
        .input-group-prepend {
            margin-right: -1px;
        }
        .input-group-append, .input-group-prepend {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }
        .input-group-text {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            padding: .375rem .75rem;
            margin-bottom: 0;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            text-align: center;
            white-space: nowrap;
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: .25rem;
        }

        .input-group>.custom-select:not(:first-child), .input-group>.form-control:not(:first-child) {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
        .input-group>.custom-file, .input-group>.custom-select, .input-group>.form-control {
            position: relative;
            -webkit-box-flex: 1;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            width: 1%;
            margin-bottom: 0;
        }
        .form-control {
            display: block;
            width: 100%;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }
    </style>
</head>
<body style="font-size: 13px;">

<div class="container">
    <br>
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <form id="location-form">
                <input type="text" name="" placeholder="Enter Address" id="location-input" class="form-control" required="">
                <br>
                <button class="btn btn-primary btn-block" type="submit">Find</button>
            </form>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-6 col-xs-12">
                <br>
                <button class="btn btn-default btn-block" type="button" data-toggle="modal" data-target="#exampleModal">Fast Location</button>
        </div>
    </div>

    <div class="card-block" id='error-page'></div>
    <div class="card-block" id='formatted-address'></div>
    <div class="card-block" id='address-component'></div>
    <div class="card-block" id='geometry'></div>
    <div class="card-block" id='button-submit'></div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="fast-map">
                    <div class="input-group mb-3">
                        <input type="hidden" id="spk" value="<?=$id?>">
                        <input type="hidden" id="kode" value="<?=$kode?>">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Latitued</span>
                        </div>
                        <input type="text" class="form-control" id="latitued" required aria-describedby="basic-addon3">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">Longitude</span>
                        </div>
                        <input type="text" class="form-control" id="longitude" required aria-describedby="basic-addon3">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-block btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script type="text/javascript">

    $('#fast-map').on('submit', function (e) {
        e.preventDefault();
        var lat = $('#latitued').val();
        var lng = $('#longitude').val();
        var spk = $('#spk').val();
        var label = 'Map-'+spk;
        var location = 'Unset';
        var kode = $('#kode').val();
        $.ajax({

            url  : 'ajx/CRUD.php?type=saveMap',
            type: 'post',
            data: 'spk='+spk+'&label='+label+'&lat='+lat+'&lng='+lng+'&location='+location+'&kode='+kode,

            success : function (msg) {
                if(msg == '1'){

                    window.top.close();
                    // var list = $('#showListCuti').hide().load('php/ajx/detailCuti.php?admin='+admin).fadeIn(1500);
                }
            }
        });

    })
    //geocode();

    //get location form

    var locationForm = document.getElementById('location-form');
    //listen for submit

    locationForm.addEventListener('submit', geocode);

    function geocode(e) {

        //prevent actual submit
        e.preventDefault();

        var location = document.getElementById('location-input').value;
        axios.get('https://maps.googleapis.com/maps/api/geocode/json', {

            params: {
                address : location,
                key: 'AIzaSyD69UFD4ZUdn7BmUmhcVjktby8EX-rvPS4'
            }
        })
            .then(function(response){
                console.log(response);

                //formatted address

                var error = response.data.error_message;
                var msg = '<div class="alert alert-danger" role="alert"><h4 class="alert-heading">Error !</h4><p>'+error+'</p></div>';

                if(error == 'undefined'){
                    document.getElementById('error-page').innerHTML = msg;
                }

                var formattedAddress = response.data.results[0].formatted_address;
                var formattedAddressOutput = '<ul class="list-group"><li class="list-group-item">'+formattedAddress+'</li></ul>';

                //address component

                var addressComponents = response.data.results[0].address_components;
                var addressComponentsOutput = '<ul class="list-group"></ul>';

                for(var i= 0; i < addressComponents.length; i++){
                    addressComponentsOutput +='<li class= "list-group-item"><strong>'+addressComponents[i].types[0]+'</strong>: '+addressComponents[i].long_name+'</li>';
                }

                addressComponentsOutput += '</ul>';

                //geometry
                var lat = response.data.results[0].geometry.location.lat;
                var lng = response.data.results[0].geometry.location.lng;
                var geometryOutput = '<ul class="list-group"><li class="list-group-item"><strong>Latitude:  </strong> '+lat+'</li> <li class="list-group-item"><strong>Longitude:  </strong> '+lng+'</li></ul>';

                var btn = '<button type="button" data-label="'+location+'" data-kode="<?=$kode?>" data-spk="<?=$id?>" data-lat="'+lat+'" data-lng="'+lng+'" data-location="'+formattedAddress+'" class="dataMap btn btn-success btn-lg btn-block">SET MAP</button>';
                //output App

                document.getElementById('formatted-address').innerHTML = formattedAddressOutput;

                document.getElementById('address-component').innerHTML = addressComponentsOutput;

                document.getElementById('geometry').innerHTML = geometryOutput;

                document.getElementById('button-submit').innerHTML = btn;


            })
            .catch(function(error){
                console.log(error);

            })

        $('#button-submit').on('click', '.dataMap', function () {


            var spk = $(this).data('spk');
            var label = $(this).data('label');
            var lat = $(this).data('lat');
            var lng = $(this).data('lng');
            var location = $(this).data('location');
            var kode = $(this).data('kode');

            $.ajax({

                url  : 'ajx/CRUD.php?type=saveMap',
                type: 'post',
                data: 'spk='+spk+'&label='+label+'&lat='+lat+'&lng='+lng+'&location='+location +'&kode='+kode,

                success : function (msg) {
                    if(msg == '1'){

                        window.top.close();
                        // var list = $('#showListCuti').hide().load('php/ajx/detailCuti.php?admin='+admin).fadeIn(1500);
                    }
                }
            });
        })
    }
</script>

</body>
</html>