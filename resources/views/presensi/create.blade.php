@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-presensi PT Satona</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <style>
        .webcam-capture,
        .webcam-capture video {
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 15px;
        }

        #map {
            height: 200px;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
@endsection

@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col">
            <input type="hidden" id="lokasi">
            <div class="webcam-capture">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            @if ($cek > 0)
            <button id="takeabsen" class="btn btn-danger btn-block">
                <ion-icon name="camera-outline" role="img" class="md hydrated"
                    aria-label="camera outline"></ion-icon>
                Absen Pulang
            </button>
            @else
                <button id="takeabsen" class="btn btn-primary btn-block">
                    <ion-icon name="camera-outline" role="img" class="md hydrated"
                        aria-label="camera outline"></ion-icon>
                    Absen Masuk
                </button>
            @endif
        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <div id="map"></div>
        </div>
    </div>

    <audio id="datang">
        <source  src="{{asset('assets/sound/datang.mp3')}}" type="audio/mpeg">
    </audio>
    <audio id="pulang">
        <source  src="{{asset('assets/sound/pulang.mp3')}}" type="audio/mpeg">
    </audio>
    <audio id="radius_sound">
        <source  src="{{asset('assets/sound/radius.mp3')}}" type="audio/mpeg">
    </audio>
@endsection

@push('myscript')
    <script>
        var datang = document.getElementById('datang');
        var pulang = document.getElementById('pulang');
        var radius_sound = document.getElementById('radius_sound');
        Webcam.set({
            height: 480,
            width: 640,
            image_format: 'jpeg',
            jpeg_quality: 80
        });
        Webcam.attach('.webcam-capture');
        var lokasi = document.getElementById('lokasi');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            lokasi.value = latitude + "," + longitude;
            var map = L.map('map').setView([latitude, longitude], 18);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            var marker = L.marker([latitude, longitude]).addTo(map);
            var circle = L.circle([-7.326446888913083, 112.74468344292505], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 50
            }).addTo(map);
        }

        function errorCallback() {
            alert("Gagal mendapatkan lokasi");
        }

        $("#takeabsen").click(function() {
            Webcam.snap(function(uri) {
                image = uri;
            });
            var lokasi = $("#lokasi").val();
            $.ajax({
                type: 'post',
                url: "{{ route('presensi.store') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    image: image,
                    lokasi: lokasi,
                },
                chache: false,
                success: function(respond) {
                    var status = respond.split("|");
                    if (status[0] == "success") {
                        if (status[2] == "in") {
                            datang.play();
                        } else {
                            pulang.play();
                        }
                        Swal.fire({
                            title: 'Barhasil !',
                            text: status[1],
                            icon: 'success',
                            confirmButtonText: 'Confirm'
                        })
                        setTimeout(() => {
                            window.location.href = '/dashboard';
                        }, 3000);
                    } else {
                        if (status[2] == "radius") {
                            radius_sound.play();
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: status[1],
                            icon: 'error',
                            confirmButtonText: 'Confirm'
                        })
                    }
                }
            })
        });
    </script>
@endpush
