<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class GuruController extends Controller
{

    public function __construct()
    {
        // $this->middleware('checkrole:3')->only('index');
        // $this->middleware('checkrole:1')->only('index','create', 'edit', 'store', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        // $nama_kelas = $request->input('nama_kelas');
        // if ($nama_kelas) {
        //     $kelas = Kelas::whereHas('guru', function ($query) use ($nama_kelas) {
        //         $query->where('nama_kelas', $nama_kelas);
        //     })->with('guru')->get();
        //     if ($kelas->isEmpty()) {
        //         $kelas = Kelas::where('nama_kelas', $nama_kelas)->with('guru')->get();
        //     }
        // } else {
        //     $kelas = Kelas::with('guru')->get();
        // }

        if(request()->ajax()){
            
            $query = DB::table('guru')
            ->join('kelas','kelas.guru_id','=','guru.id')
            ->select('guru.*','kelas.nama_kelas', 'kelas.id as kelas_id');

            $filterkelas = $request->filters['filterkelas'];
            if(!empty($filterkelas) && $filterkelas !== '*'){
                $query->where('kelas.id', $filterkelas);
            }else{
                $query;
            }

            $query = $query->get();
            
            return DataTables::of($query)
            
            ->addColumn('action', function ($guru) {
                if (auth()->user()->role_id == 1) {
                    $env = url('');
                    $action = "
                    <a href=\"$env/guru/$guru->id/edit\"  class=\"btn btn-primary \">Edit</a>
                    <a href=\"$env/guru/$guru->id/destroy\"  class=\"btn btn-danger \">Delete</a>
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
        
        $Kelas = Kelas::all();
    
        return view('guru.index',compact('Kelas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Kelas $kelas)
    {
        $Kelas = Kelas::all();
        return view('Guru.create', compact('Kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required',
            'email' => 'required',
            'kelas_id' => 'required',
            'password' => 'required',
        ]);
    
        $user = User::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $guru = Guru::where('user_id', $user->id)->create([
            'user_id' => $user->id,
            'nama' => $user->nama,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $kelas_id = $request->kelas_id;
        $kelas = Kelas::find($kelas_id);
        if (!$kelas) {
            return redirect()->back()->with('error', 'Kelas tidak ditemukan');
        }
        
        $kelas->update([
            'guru_id' => $guru->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return redirect()->route('guru.index')
                        ->with('success','Berhasil Menyimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guru  $Guru
     * @return \Illuminate\Http\Response
     */
    public function show(Guru $Guru)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guru  $Guru
     * @return \Illuminate\Http\Response
     */
    public function edit(Guru $Guru)
    {

        $Guru = Guru::all()->where('id', $Guru->id);
        $Kelas = Kelas::all();

        return view('Guru.edit',compact('Guru', 'Kelas'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guru  $Guru
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id )
    {

        $user = Guru::find($id);
        $user = User::where('id', $user->user_id)->first();
        $user->nama = $request->nama;
        $user->nis = $request->nis;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->alamat = $request->alamat;
        $user->no_hp = $request->no_hp;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $guru = Guru::where('user_id', $user->id)->first();
        $guru->nama = $request->nama;
        $guru->save();

        $kelas_id = $request->kelas_id;
        $kelas = Kelas::find($kelas_id);
        if (!$kelas) {
            return redirect()->back()->with('error', 'Kelas tidak ditemukan');
        }

       $kelas->update([
            'guru_id' => $guru->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
   
    
        return redirect()->route('guru.index')
                        ->with('success','Berhasil Update !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guru  $Guru
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $Guru = Guru::find($id);
        User::where('id', $Guru->user_id)->delete();
        $Guru->delete();
        if ($Guru->kelas) {
            $Guru->kelas->guru_id = null;
            $Guru->kelas->save();
         }

        return redirect()->route('guru.index')
                        ->with('success','Berhasil Hapus !');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $guru = Guru::where('nama', 'LIKE', "%$query%")
            ->orWhere('email', 'LIKE', "%$query%")
            ->get();

        return view('guru.index', compact('guru'));
    }
}