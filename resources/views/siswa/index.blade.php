@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Data Siswa</h2>
            </div>
            <div class="pull-right">
            @if(Auth::user()->role_id == "1")
                <a class="btn btn-success" href="{{ route('siswa.create') }}"> Create</a>
            @endif
                <div class="form-group d-flex align-items-center">
                    <select name="filter_kelas" id="filter_kelas" class="form-control" style="width:100px">
                        <option value="*">Semua Kelas</option>
                        @foreach($kelas as $k)
                        <option value="{{ $k->id }}">
                            {{ $k->nama_kelas }}
                        </option>
                        @endforeach
                    </select>
                </div>
         
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                    <table class="table" id="table_siswa">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>NIS</th>
                                <th>Nama Kelas</th>
                                <th>Wali Kelas</th>
                            @if(Auth::user()->role_id == "1")
                                <th>Aksi</th>
                            @endif
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
                'filterkelas': $('#filter_kelas').val(),
            }
        }
        
        $('#filter_kelas').change(function(){
            tablesiswa.draw()  
        });



    window.tablesiswa  = $('#table_siswa')
        .DataTable({
            processing: true,
            serverSide: true,
            retrieve: true,
            responsive: false,
            buttons: [
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4]
                    }
                },
            ],
            aaSorting : [],
            ajax: {
                url : "{{route('siswa.index')}}",
                data: function(data){
                    data.filters = getFilter()
                }
            },
            language: {
                "lengthMenu": "Show Menu",
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
            { data: 'nama'},
            { data: 'nis'},
            { data: 'nama_kelas'},
            { data: 'nama_guru'},
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
