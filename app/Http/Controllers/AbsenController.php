<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use Illuminate\Http\Request;
use App\Exports\AbsenExport;
use App\Models\Kelas;
use App\Models\SiswaKelas;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
// use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Yajra\DataTables\DataTables;

class AbsenController extends Controller
{
    
    public function __construct()
    {
        // $this->middleware('checkrole:3')->only('index');
        // $this->middleware('checkrole:1')->only('create', 'edit');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(request()->ajax()){
            
            $query = DB::table('absen')
            ->join('siswa','siswa.id','=','absen.siswa_id')
            ->join('users','users.id', '=', 'siswa.user_id')
            ->join('siswa_kelas','siswa_kelas.siswa_id','=','siswa.id')
            ->join('kelas','kelas.id','=','siswa_kelas.kelas_id')
            ->select('absen.*','siswa.nama','users.nis','kelas.nama_kelas');


            $filter_mulai = $request->filters['filter_mulai'];
            $filter_selesai = $request->filters['filter_selesai'];
            if(!empty($filter_mulai) && $filter_mulai !== '*'){
                $query->whereBetween('absen.date', [$filter_mulai, $filter_selesai]);
            }else{
                $query;
            }

            $filter_kelas = $request->filters['filter_kelas'];
            if(!empty($filter_kelas) && $filter_kelas !== '*'){
                $query->where('kelas.id', $filter_kelas);
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
            // ->rawColumns(['action'])
            ->make(true);
        }

        $kelas = Kelas::all();
    
        return view('absens.index', compact('kelas'));
    }
    
    
    
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Absen  $absen
     * @return \Illuminate\Http\Response
     */
    public function show(Absen $absen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Absen  $absen
     * @return \Illuminate\Http\Response
     */
    public function edit(Absen $absen)
    {
       //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Absen  $absen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Absen $absen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absen  $absen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absen $absen)
    {
        $absen->delete();

        return redirect()->route('absens.index')
                        ->with('success','Berhasil Hapus !');
    }
    
    

    public function export(Request $request)
    {
        // $start_date = $request->query('start_date');
        // $end_date = $request->query('end_date');
        // $kelas_id = $request->query('kelas_id');

    
        // $absens = Absen::query()
        // ->select('absen.date', 'siswa.nama', 'users.nis', 'absen.keterangan')
        // ->join('siswa', 'absen.siswa_id', '=', 'siswa.id')
        // ->join('users', 'siswa.user_id', '=', 'users.id')
        // ->join('siswa_kelas', 'siswa.id', '=', 'siswa_kelas.siswa_id')
        // ->where('siswa_kelas.kelas_id', '=', $kelas_id)
        // ->whereBetween('absen.date', [$start_date, $end_date])
        // ->get();

    
        // return Excel::download(new AbsenExport($absens, $start_date, $end_date, $kelas_id), 'absens.xlsx');


    }
    
}
