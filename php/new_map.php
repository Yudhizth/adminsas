<?php
$id = $_GET['spk'];

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

    <div class="card-block" id='error-page'></div>
    <div class="card-block" id='formatted-address'></div>
    <div class="card-block" id='address-component'></div>
    <div class="card-block" id='geometry'></div>
    <div class="card-block" id='button-submit'></div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script type="text/javascript">
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

                var btn = '<button type="button" data-label="'+location+'" data-spk="<?=$id?>" data-lat="'+lat+'" data-lng="'+lng+'" data-location="'+formattedAddress+'" class="dataMap btn btn-success btn-lg btn-block">SET MAP</button>';
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

            $.ajax({

                url  : 'ajx/CRUD.php?type=saveMap',
                type: 'post',
                data: 'spk='+spk+'&label='+label+'&lat='+lat+'&lng='+lng+'&location='+location,

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