@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Data Guru</h2>
            </div>
            <div class="pull-right">
            @if(Auth::user()->role_id == "1")
                <a class="btn btn-success" href="{{ route('guru.create') }}"> Create</a>
            @endif
            <div class="form-group d-flex align-items-center mt-3">
                    <select name="kelas_id" id="nama_kelas" class="form-control" style="width:100px">
                        <option value="*">-- All --</option>
                        @foreach($Kelas as $k)
                        <option value="{{ $k->id }}">
                            {{ $k->nama_kelas }}
                        </option>
                        @endforeach
                    </select>
                    <!-- <button type="submit" class="btn btn-primary ml-2">Filter</button> -->
                </div>
        
            @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <table class="table" id="data-table-guru">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Nama Guru</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>



<script class="text/javascript">
    
    $(document).ready(function(){
        var getFilter = function(){
            return {
                'filterkelas': $('#nama_kelas').val(),
            }
        }
        
        $('#nama_kelas').change(function(){
            tableKelas.draw()  
        });



    window.tableKelas  = $('#data-table-guru')
        .DataTable({
            processing: true,
            serverSide: true,
            retrieve: true,
            responsive: false,
            buttons: [
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2 ]
                    },
                    className: 'btn-success btn mb-3'
                },
            ],
            aaSorting : [],
            ajax: {
                url : "{{route('guru.index')}}",
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
            { data: 'nama_kelas'},
            { data: 'nama'},
            { data: 'action'},
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