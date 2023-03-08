@extends('layouts.app')

<style>
#map {
        width: 100%;
        height: 15vh;
        margin-bottom: 50px;
    }
</style>

@section('content')
<div class="container">
    <div class="card text-center">
        <div class="card-header">
            ABSENSI SISWA || SMK NEGERI 1 BALIKPAPAN
        </div>
        <div class="card-body">
            

        <div class="greet">

        <h4>
            @if(date('H') < 12)
                Selamat Pagi !
            @elseif(date('H') < 18)
                Selamat Siang !
            @else
                Selamat Malam !
            @endif
        </h4>   
            <h2 class="card-text">
                {{ Auth::user()->nama }}
            </h2>
            <h5 class="card-text text-black">Silahkan Absen Dulu Ya...</h5>
            <div class="keterangan mt-4">
               <p> Jam Kehadiran : {{ $absen->jam_kedatangan ?? '-' }} ,  Jam Kepulangan : {{ $absen->jam_kepulangan ?? '-' }}</p>
                    <p></p>
                    <p> Keterangan : {{ $absen->keterangan ?? '-'}}</p>
            </div>
        </div>
       

        <div class="tombol-absen mt-3">

            <button class="btn btn-lg btn-primary text-white mt-3" id="accesscamera" data-toggle="modal" data-target="#photoModal">Absen</button>

            <a href="/izin" class="btn btn-danger btn-lg mt-3">Izin</a>
            
        </div>





<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Absen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body">
    <div>
        <div id="map"></div>
        <div id="my_camera" class="d-block mx-auto rounded overflow-text "></div>
        <p class="mt-1">Silahkan Foto Untuk Melakukan Absensi</p>

    </div>
    <div id="results" class="d-none"></div>
        <!-- <form method="post" id="photoForm">
        </form> -->
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-warning mx-auto text-white" id="takephoto">Capture Photo</button>
        <a type="button" class="btn btn-warning mx-auto text-white d-none" id="retakephoto">Retake</a>
        @if ($errors->first('set_lat_input'))
        <div class="alert alert-danger">
            <ul>
                <p>{{ $errors->first('set_lat_input') }}</p>
            </ul>
        </div>
        @endif      
        @if (!is_null($absen))
                @if (is_null($absen->jam_kepulangan))
                <form method="POST" action="/balik/{{ Auth::id() }}"  id="photoFormBalik" enctype="multipart/form-data">
                    @csrf
                    <input class="set-lang-input" name="set_lang_input" type="hidden"></input>
                    <input class="set-lat-input" name="set_lat_input" type="hidden"></input>
                    <input id="photoStore" name="photoStore" value="" type="hidden">

                    <!-- <button class="btn btn-primary ">PULANG</button> -->

                    <!-- Button Submit Picture -->
                    <button type="submit" class="btn btn-success mx-auto text-white d-none" id="uploadphoto" form="photoFormBalik" hidden>Absen Pulang</button>

                </form>
                @else
                @endif
                <div>
            @else
            <form method="POST" action="/in" id="photoForm"  enctype="multipart/form-data">
                    @csrf
                    <input class="set-lang-input" name="set_lang_input" type="hidden"></input>
                    <input class="set-lat-input" name="set_lat_input" type="hidden"></input>
                    <input id="photoStore" name="photoStore" value="" type="hidden">
                    <!-- <button class="btn btn-success mt ">HADIR</button> -->

                    <!-- Button Submit Picture -->
                    <button type="submit" class="btn btn-success mx-auto text-white d-none" id="uploadphoto" form="photoForm" hidden>Absen Hadir</button>

                </form>
                @endif
            </div>
        </div>
    </div>



        <!-- latitude <span id="set-lat">{{$locationData->latitude}} </span>
        longitude <span id="set-long">{{$locationData->longitude}} </span> -->
        
        </div>
    </div>
</div>
<h5 class="mt-5" align="center">
    <?php
        date_default_timezone_set('Asia/Jakarta');
        echo date('d-m-Y');
        echo ' &nbsp;&nbsp; <i id="h"></i> : <i id="m"></i> : <i id="s"></i>';
    ?>
</h5>

<script>
    window.setTimeout("waktu()", 1000);
    function waktu() {
        var waktu = new Date();
        setTimeout("waktu()", 1000);
        document.getElementById("h").innerHTML = waktu.getHours();
        document.getElementById("m").innerHTML = waktu.getMinutes();
        document.getElementById("s").innerHTML = waktu.getSeconds();
    }
</script>

<script>
// Map initialization 
const mapDiv = document.getElementById("map");
var map = L.map('map').locate({setView: true, maxZoom: 20});

//osm layer
var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
});
osm.addTo(map);

const resizeObserver = new ResizeObserver(() => {
map.invalidateSize();
});

const radiusAbsen = L.circle([-1.2496970, 116.87726780],{
    radius: 50,
}).addTo(map)


function onLocationFound(e) {
    L.marker(e.latlng).addTo(map)
        map.setView([e.latitude,e.longitude],20);

        const absen = map.distance(e.latlng, radiusAbsen.getLatLng());
        const isInside = absen <= radiusAbsen.getRadius();
        if (!isInside) {
            alert('You must be inside the radius to submit the form');
            e.preventDefault();
        return false;
        }
        radiusAbsen.setStyle({
            color: isInside ? 'green' : 'red',
            fillColor: isInside ? 'green' : 'red',
        });

        const latElementInput = document.querySelector(".set-lat-input");
        const lngElementInput = document.querySelector(".set-lang-input");
        latElementInput.value = e.latitude;
        lngElementInput.value = e.longitude;
}
map.on('locationfound', onLocationFound);
// map.setView([],12)

// map.locate({setView: true, maxZoom: 12});

resizeObserver.observe(mapDiv);

// L.control.locate().addTo(map);

// map.on('locationfound', (e) => {
//     console.log(e);

//     // const latElement = document.getElementById('set-lat');
//     // const lngElement = document.getElementById('set-long');

//     const latElementInput = document.querySelector(".set-lat-input");
//     const lngElementInput = document.querySelector(".set-lang-input");

    
//     // latElement.innerHTML = e.latitude;
//     // lngElement.innerHTML = e.longitude;


//     latElementInput.value = e.latitude;
//     lngElementInput.value = e.longitude;
//     console.log(latElementInput);
// });
map.on('locationerror', (e) => {
    alert('location error: Tidak Mendapatkan Lokasi');
});


</script>

<script>
$(document).ready(function() {
    Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90
    });

    $('#accesscamera').on('click', function() {
        Webcam.reset();
        Webcam.on('error', function() {
            $('#photoModal').modal('hide');
            swal({
                title: 'Warning',
                text: 'Please give permission to access your webcam',
                icon: 'warning'
            });
        });
        Webcam.attach('#my_camera');
    });

    $('#takephoto').on('click', take_snapshot);

    $('#retakephoto').on('click', function() {
        $('#my_camera').addClass('d-block');
        $('#my_camera').removeClass('d-none');

        $('#results').addClass('d-none');

        $('#takephoto').addClass('d-block');
        $('#takephoto').removeClass('d-none');

        $('#retakephoto').addClass('d-none');
        $('#retakephoto').removeClass('d-block');

        $('#uploadphoto').addClass('d-none');
        $('#uploadphoto').removeClass('d-block');
    });

    $('#photoForm').on('submit', function(e) {
        // console.log($(this).serialize());

        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('in')}}",
            type: 'POST',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
                // console.log(data);
                if(data == 'success') {
                    Webcam.reset();

                    $('#my_camera').addClass('d-block');
                    $('#my_camera').removeClass('d-none');

                    $('#results').addClass('d-none');

                    $('#takephoto').addClass('d-block');
                    $('#takephoto').removeClass('d-none');

                    $('#retakephoto').addClass('d-none');
                    $('#retakephoto').removeClass('d-block');

                    $('#uploadphoto').addClass('d-none');
                    $('#uploadphoto').removeClass('d-block');

                    $('#photoModal').modal('hide');

                    swal({
                        title: 'Success',
                        text: 'Photo uploaded successfully',
                        icon: 'success',
                        buttons: false,
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        timer: 2000
                    })

                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
                else {
                    swal({
                        title: 'Error',
                        text: 'Something went wrong',
                        icon: 'error'
                    })
                }
            }
        })
    })

    $('#photoFormBalik').on('submit', function(e) {

        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('balik')}}",
            type: 'POST',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(data) {
                // console.log(data);
                if(data == 'success') {
                    Webcam.reset();

                    $('#my_camera').addClass('d-block');
                    $('#my_camera').removeClass('d-none');

                    $('#results').addClass('d-none');

                    $('#takephoto').addClass('d-block');
                    $('#takephoto').removeClass('d-none');

                    $('#retakephoto').addClass('d-none');
                    $('#retakephoto').removeClass('d-block');

                    $('#uploadphoto').addClass('d-none');
                    $('#uploadphoto').removeClass('d-block');

                    $('#photoModal').modal('hide');

                    swal({
                        title: 'Success',
                        text: 'Photo uploaded successfully',
                        icon: 'success',
                        buttons: false,
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        timer: 2000
                    })

                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
                else {
                    swal({
                        title: 'Error',
                        text: 'Something went wrong',
                        icon: 'error'
                    })
                }
            }
        })
    })
})


function take_snapshot()
{
//take snapshot and get image data
Webcam.snap(function(data_uri) {
    //display result image
    $('#results').html('<img src="' + data_uri + '" class="d-block mx-auto rounded"/>');

    var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');

    $('#photoStore').val(raw_image_data);
});

$('#my_camera').removeClass('d-block');
$('#my_camera').addClass('d-none');

$('#results').removeClass('d-none');

$('#takephoto').removeClass('d-block');
$('#takephoto').addClass('d-none');

$('#retakephoto').removeClass('d-none');
$('#retakephoto').addClass('d-block');

$('#uploadphoto').removeClass('d-none');
$('#uploadphoto').addClass('d-block');
}
</script>


@endsection
