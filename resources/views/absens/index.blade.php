@extends('layout.master')

<head>
<style>
    #table_absen {
        width: 100%;
        margin: 0;
    }
</style>
</head>

@section('content')
    <div class="row ">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Data Absen</h2>
            </div>
            <div class="pull-right">
                    <div class="form-group">
                        <label for="start_date">Start Date:</label>
                        <input type="date" name="filter_mulai" class="form-control" id="filter_mulai" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date:</label>
                        <input type="date" name="filter_selesai" class="form-control" id="filter_selesai" required>
                    </div>
                    <div class="form-group">
                        <label for="kelas_id">Kelas:</label>
                        <select name="filter_kelas" class="form-control" id="filter_kelas" required>
                            <option value="*">Semua Kelas</option>
                            @foreach ($kelas as $kls)
                                <option value="{{$kls->id}}">{{$kls->nama_kelas}}</option>
                                @endforeach
                        </select>
                    </div>
                <button class="btn btn-primary btn-filter" type="submit">Filter</button>
        </div>
        <table class="table" id="table_absen">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Jam Kedatangan</th>
                                <th>Jam Kepulangan</th>
                                <th>Hari</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
<!-- 
    <table class="table  mb-4" id="table_absen">
        <thead>
            <th>No</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jam Kedatangan</th>
            <th>Jam Kepulangan</th>
            <th>Hari</th>
            <th>Keterangan</th>
            </thead>
       <tbody>

       </tbody>
    </table> -->

   

    <script class="text/javascript">
    
    $(document).ready(function(){
        var getFilter = function(){
            return {
                'filter_kelas': $('#filter_kelas').val(),
                'filter_mulai': $('#filter_mulai').val(),
                'filter_selesai': $('#filter_selesai').val(),
            }
        }
        
        $('.btn-filter').click(() => {
            tableKelas.draw();
        });



    window.tableKelas  = $('#table_absen')
        .DataTable({
            processing: true,
            serverSide: true,
            retrieve: true,
            responsive: true,
            buttons: [
                {
                    extend: 'excelHtml5',
                    className: 'btn-success btn mb-3 mt-3'
                },
            ],
            aaSorting : [],
            ajax: {
                url : "{{route('absens.index')}}",
                data: function(data){
                    data.filters = getFilter()
                }
            },
            language: {
                "lengthMenu": "Show MENU",
                "emptyTable" : "Tidak ada data terbaru 💻",
                "zeroRecords": "Data tidak ditemukan 😞",
            },
            dom:
            "<'row'" +
            "<'col-4 col-xl-6 d-flex align-items-center justify-content-start'B>" +
            "<'col-8 col-xl-6 d-flex align-items-center justify-content-lg-end justify-content-start 'f>" +
            ">" +
            
            "<'table-responsive'tr>" +
            
            "<'row'" +
            "<'col-sm-12 col-xl-5 d-flex align-items-center justify-content-center justify-content-xl-start'i>" +
            "<'col-sm-12 col-xl-7 d-flex align-items-center justify-content-center justify-content-xl-end'p>" +
            ">",
            columns: [
            { data: 'DT_RowIndex'},
            { data: 'nis'},
            { data: 'nama'},
            { data: 'nama_kelas'},
            { data: 'jam_kedatangan'},
            { data: 'jam_kepulangan'},
            { data: 'date'},
            { data: 'keterangan'},
            
            ],
            columnDefs: [
            {
                targets: 0,
                orderable : false,
                searchable : false,
                className: 'text-center',
            },
            ],
        });
    });
</script>
@endsection

