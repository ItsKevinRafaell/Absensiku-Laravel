@extends ('layouts.app')
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

@section ('content')
<div class="student-profile py-4">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="card shadow-sm">
          @foreach ($users as $user)

            @php

            $role = App\Models\Role::where('id', $user->role_id)->first();
            $siswa = App\Models\Siswa::where('user_id', $user->id)->first();
            $siswakelas = App\Models\SiswaKelas::where('siswa_id', $siswa->id)->first();
            $datakelas = App\Models\Kelas::where('id', $siswakelas->kelas_id)->first();
            $datawali = App\Models\Guru::where('id', $datakelas->guru_id)->first();
            @endphp

            <div class="card-header bg-transparent text-center">
              <img class="profile_img mb-3 rounded-circle img-fluid" src="https://img.freepik.com/free-vector/businessman-character-avatar-isolated_24877-60111.jpg?w=740&t=st=1676269308~exp=1676269908~hmac=b4056143621a2185086392f8e1b03acf5d8f0ffcbae1a19275731708aa2a495c" width="250" alt="" style="max-width: calc(100% - 80px);">
              <h3>{{ $user->nama ?? '-'}}</h3>
              <p class="mb-0"><strong class="pr-1"></strong>{{ $user->nis ?? '-'}}</p>
          </div>

          <div class="card-body text-center">
            <p class="mb-0"><strong class="pr-1">Kelas:</strong>{{$datakelas->nama_kelas ?? '-'}}</p>
            <p class="mb-0"><strong class="pr-1">Email:</strong>{{ $datawali->nama ?? '-'}}</p>
            <p class="mb-0"><strong class="pr-1">Email:</strong>{{ $user->email ?? '-'}}</p>
            <p class="mb-0"><strong class="pr-1">No Handphone:</strong>{{ $user->no_hp ?? '-'}}</p>
            <p class="mb-0"><strong class="pr-1">Jenis Kelamin:</strong>{{ $user->jenis_kelamin ?? '-'}}</p>
            <p class="mb-0"><strong class="pr-1">Alamat:</strong>{{ $user->alamat ?? '-'}}</p>
            <p class="mb-0"><strong class="pr-1">Role:</strong>{{ $role->role}}</p>
            <form action="{{ route('home') }}">
                <button class="btn btn-primary mt-3" type="submit">Kembali</button>
            </form>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

@endsection