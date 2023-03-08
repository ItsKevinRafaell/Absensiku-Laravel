@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Data Admin</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('admins.create') }}"> Create</a>
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="/admins/search" method="GET">
                    <div class="input-group">
                        <input type="text" name="cari" class="form-control bg-white border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" autofocus value="{{ old('cari') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div style="overflow: auto;" class="mb-4">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            @foreach ($admins as $admin)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->email }}</td>
                <td>
                    <form action="{{ route('admins.destroy',$admin->id) }}" method="POST">
                        <a class="btn btn-primary" href="{{ route('admins.edit',$admin->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin?')" type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    {!! $admins->links() !!}
@endsection
