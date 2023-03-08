@extends('layout.master')

<head>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

@section('content')
    <div class="text" align="center">
        <h1 class="mt-5">DASHBOARD ABSENSI SISWA</h1>
        <h2 class="mb-4">SMK NEGERI 1 BALIKPAPAN</h2>
        <hr>
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
        <h4 class="mt-5">
            <?php
                date_default_timezone_set('Asia/Jakarta');
                echo date('d-m-Y');
                echo ' &nbsp;&nbsp; <i id="h"></i> : <i id="m"></i> : <i id="s"></i>';
            ?>
        </h4>

        @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
       
            <div class="import-button mt-4">
                <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Import Data Users
                </button>
            </div>

    </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{route('importexcel')}}" method="POST" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Import Data Users</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                {{ csrf_field()}}
                {{ method_field('POST')}}
                
                <div class="form-group">
                    <input type="file" name="file" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary ml-2">Import</button>
            </div>
        </form>
    </div>
  </div>
</div>



    <!-- <div class="container w-50">
        <div class="row align-content-center">
            <canvas id="myChart"></canvas>    
            <canvas id="attendanceChart"></canvas>
        </div>
    </div>
     -->

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
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie', // Set chart type to "pie"
        data: {
            labels: ['Total Siswa: {{ $totalStudents }}', 'Total Guru: {{ $totalTeachers }}'],
            datasets: [{
                label: '# of People',
                data: [<?php echo $totalStudents; ?>, <?php echo $totalTeachers; ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            cutout: '0%', // set the size of the hole in the middle
        scales: {
                y: {
                    display: false // hide the y-axis labels
                }
            }
        }
    });
</script>

<script>
    var ctx = document.getElementById('attendanceChart').getContext('2d');
var chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Present', 'Late', 'Absent'],
        datasets: [{
            label: 'Attendance',
            darta : <? echo $hadir ?>, <? echo $telat ?>, <? echo $absen ?>,
            backgroundColor: ['#2ecc71', '#f1c40f', '#e74c3c'],
        }]
    },
    options: {
        responsive: true,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

</script>

@endsection
