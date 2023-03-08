@extends('layouts.app')

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
                <!-- <div class="keterangan mt-4">
                        <p> Jam Kehadiran : {{ $absen->jam_kedatangan ?? '-' }} ,  Jam Kepulangan : {{ $absen->jam_kepulangan ?? '-' }}</p>
                        <p> Keterangan : {{ $absen->keterangan ?? '-'}}</p>
                </div> -->
            </div>
            <div class="tombol-absen mt-3">
                <a class="btn btn-lg btn-primary text-white mt-3" href="/absen">Absen Harian</a>
            </div>
        </div>

    

        <h5 class="mt-5" align="center">
            <?php
                date_default_timezone_set('Asia/Jakarta');
                echo date('d-m-Y');
                echo ' &nbsp;&nbsp; <i id="h"></i> : <i id="m"></i> : <i id="s"></i>';
            ?>
        </h5>
    </div>

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


@endsection
