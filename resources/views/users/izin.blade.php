@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card text-center mt-5 mb-5">
            <div class="card-header">
                ABSENSI SISWA  &nbsp; | &nbsp; KETIDAKHADIRAN
            </div>
            <form action="{{ url('izin') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                        <label for="" class="mt-3">Keterangan :</label>
                        <select class="form-control" aria-label="Default select example"  name="keterangan">
                            <option selected> - Input Keterangan - </option>
                            <option value="Izin">Izin</option>
                            <option value="Sakit">Sakit</option>
                        </select>
                        <div class="mt-5">
                            <label for="">Bukti :</label>
                            <input class="form-control" type="file" name="bukti" accept="image/png, image/jpg, image/jpeg"  type="file" id="formFile">
                        </div>
                        <div class="mt-5">
                            <label for="">Catatan :</label>
                            <textarea class="form-control" name="catatan" id="" cols="50" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-5">KIRIM</button>
                    </div>
                </div>
            <!-- form fields go here -->
        </form>
    </div>
@endsection