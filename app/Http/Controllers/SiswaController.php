<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\SiswaKelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SiswaController extends Controller
{
    
    public function __construct()
    {
        // $this->middleware('checkrole:3')->only('index');
        // $this->middleware('checkrole:3')->only('create', 'edit');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(request()->ajax()){
            
            $query = DB::table('siswa')
            ->join('siswa_kelas','siswa_kelas.siswa_id','=','siswa.id')
            ->join('kelas','kelas.id','=','siswa_kelas.kelas_id')
            ->join('guru','guru.id','=','kelas.guru_id')
            ->join('users','users.id','=','siswa.user_id')
            ->select('siswa.*','kelas.nama_kelas', 'kelas.id as kelas_id', 'guru.nama as nama_guru', 'users.nis');

            $filterkelas = $request->filters['filterkelas'];
            if(!empty($filterkelas) && $filterkelas !== '*'){
                $query->where('kelas.id', $filterkelas);
            }else{
                $query;
            }

            $query = $query->get();
            
            return DataTables::of($query)
            
            ->addColumn('action', function ($siswa) {
                if (auth()->user()->role_id == 1) {
                    $env = url('');
                    $action = "
                    <a href=\"$env/siswa/$siswa->id/edit\"  class=\"btn btn-primary \">Edit</a>
                    ";
                } else {
                    $action = "";
                }
                return "$action";
            })
        
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
        }

        $kelas = Kelas::all();

        return view('siswa.index', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Siswa = Siswa::all();
        $Guru = Guru::all();
        $Kelas = Kelas::all();
        return view('siswa.create', compact('Guru', 'Kelas', 'Siswa'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required',
            'nis' => 'required',
            'kelas_id' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
    
        $user = User::create([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $siswa = Siswa::create([
            'user_id' => $user->id,
            'nama' => $user->nama,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        SiswaKelas::create([
            'siswa_id' => $siswa->id,
            'kelas_id' => $request->kelas_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        


        return redirect()->route('siswa.index')->with('success', 'Berhasil Menyimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Siswa $Siswa
     * @return \Illuminate\Http\Response
     */
    public function show(Siswa $Siswa, $id)
    {
        $Siswa = Siswa::all();
        dd($Siswa);
        if($Siswa){
            return redirect()->back()->with('error', 'Siswa Tidak Di Temukan.');
            return view ('siswa.show', compact('Siswa'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $Siswa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Siswa = Siswa::find($id);
        $Guru = Guru::all();
        $Kelas = Kelas::all();
        $User = User::all('nis');
        return view('siswa.edit', compact('Siswa', 'Guru', 'Kelas', 'User'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Siswa  $Siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id )
    {

        $request->validate([
            'nama' => 'required',
            'nis' => 'required',
            'kelas_id' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = Siswa::find($id);
        $user = User::where('id', $user->user_id)->first();
        $user->nama = $request->nama;
        $user->nis = $request->nis;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->alamat = $request->alamat;
        $user->no_hp = $request->no_hp;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $siswa = Siswa::where('user_id', $user->id)->first();
        $siswa->nama = $request->nama;
        $siswa->save();

        $siswaKelas = SiswaKelas::where('siswa_id', $siswa->id)->first();
        $siswaKelas->kelas_id = $request->kelas_id;
        $siswaKelas->save();

        // SiswaKelas::where('siswa_id', $Siswa->id)->update([
        //     'siswa_id' => $siswa->id,
        //     'kelas_id' => $request->kelas_id,
        //     'updated_at' => now(),
        //     'created_at' => now(),
        // ]);
        

        return redirect()->route('siswa.index')
            ->with('success', 'Berhasil Update !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Siswa  $Siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $siswa = Siswa::find($id);
        $user = User::where('id', $siswa->user_id)->first();
        $siswa->delete();
        $user->delete();
        

        return redirect()->route('siswa.index')
            ->with('success', 'Berhasil Hapus !');
    }

    public function profile($id){
        $users = User::all()->where('id', $id);
        
        return view('siswa.profile', compact('users'));
    }

  
}
