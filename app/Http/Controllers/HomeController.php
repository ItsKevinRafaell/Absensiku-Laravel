<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;
use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use App\Models\Siswa;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Psy\Readline\Hoa\Console;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index( Request $request, User $user, Absen $absen)
    {
        $siswa = Siswa::where('user_id', Auth::id())->first();
        $date = date('Y-m-d');

        $absen = Absen::where('siswa_id', $siswa->id)
                    ->whereDate('date', $date)
                    ->first();

        $user = User::select('nama')->get();

        return view('users.dashboard', compact( 'user', 'absen'));
    }

    public function absen( Request $request, User $user, Absen $absen)
    {
        $date = Carbon::today()->toDateString();
        $userIp = $request->ip();
        $locationData = Location::get('https://'.$request->ip()); // https or http according to your necessary.

        $siswa = Siswa::where('user_id', Auth::id())->first();
        $date = date('Y-m-d');

        $absen = Absen::where('siswa_id', $siswa->id)
                    ->whereDate('date', $date)
                    ->first();

        $user = User::select('nama')->get();
        return view('users.index', compact('locationData', 'user', 'absen', ));
    }




    public function dashboard() {

        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalStudents = Siswa::count();
        $totalTeachers = User::where('role_id', '3')->count();

        $today = date('Y-m-d');
        $absen = Absen::whereDate('created_at', $today)->get();

        $hadir = $absen->where('keterangan', 'Hadir')->count();
        $terlambat = $absen->where('keterangan', 'Terlambat')->count();
        $izin = $absen->where('keterangan', 'Izin')->count();
     
        return view('dashboard', compact('totalSiswa', 'totalGuru', 'totalStudents', 'totalTeachers', 'hadir', 'terlambat', 'izin'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'image' => 'required',
        ]);
    
        // The validated data can now be used safely to create a new post.
        // ...

        $img = $request->image;
        $folderPath = "uploads/";
        
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';
        
        $file = $folderPath . $fileName;
        Storage::put($file, $image_base64);
        
        dd('Image uploaded successfully: '.$fileName);
    }

    public function in(Request $request){

        $request->validate([
            'set_lat_input' => 'required',
            'set_lang_input' => 'required',
        ],
        [
            'set_lat_input.required' => 'Tidak Mendapatkan Lokasi Anda Saat ini, Silahkan Klik Tombol Lokasi Pada Map Untuk Menemukan Lokasi Anda Saat Ini.',
        ]);

        $image = base64_decode($request->photoStore);
        $safeName = 'clock_in_' . collect(explode(' ', auth()->user()->name))->join('_'). '_' . Carbon::now()->toDateString() . '.png';
        $fullpath = 'absensi/'.$safeName;
        Storage::disk('public')->put($fullpath, $image);

        $validatedData = $request->validate([
            'set_lat_input' => 'required',
            'set_lang_input' => 'required',
        ],
        [
            'set_lat_input.required' => 'Tidak Mendapatkan Lokasi Anda Saat ini, Silahkan Klik Tombol Lokasi Pada Map Untuk Menemukan Lokasi Anda Saat Ini.',
        ]);
        

        $timeLimit = new DateTime('07:15'); // The time limit for being considered late
        $arrivalTime = new DateTime(date('H:i')); // The student's arrival time
        
        $isLate = $arrivalTime > $timeLimit; // Check if the student is late

        $date = Carbon::today()->toDateString();

        $user = User::find(Auth::id());
        $siswa = Siswa::where('user_id', $user->id)->first();

        if ($siswa) {
            $absen = Absen::where('siswa_id', $siswa->id)
                                                    ->whereDate('date', $date)
                                                    ->first();
            if (!$absen) {
                $absen = Absen::create([
                    'siswa_id' => $siswa->id,
                    'jam_kedatangan' => date('H:i'),
                    'keterangan' => $isLate ? 'Terlambat' : 'Hadir',
                    'latitude' => $validatedData['set_lat_input'],
                    'longitude'=> $validatedData['set_lang_input'],
                    'file_kedatangan' => $fullpath,
                    'date' => $date,
                    // Other attributes
                ]);
            }
        }
        
        return response()->json('success', 200);
    }

    public function out(Request $request){
        Log::info($request->all());

        $image = base64_decode($request->photoStore);
        $safeName = 'clock_out_' . collect(explode(' ', auth()->user()->name))->join('_'). '_' . Carbon::now()->toDateString() . '.png';
        $fullpath = 'absensi/'.$safeName;
        Storage::disk('public')->put($fullpath, $image);
    
    
        $validatedData = $request->validate([
            'set_lat_input' => 'required',
            'set_lang_input' => 'required',
        ],
        [
            'set_lat_input.required' => 'Tidak Mendapatkan Lokasi Anda Saat ini, Silahkan Klik Tombol Lokasi Pada Map Untuk Menemukan Lokasi Anda Saat Ini.',
    
        ]);

        $siswa = Siswa::where('user_id', Auth::id())->first();
    
        Absen::where('siswa_id', $siswa->id)
        ->whereDate('created_at', Carbon::today())
        ->update([
            'jam_kepulangan' => date('H:i'),
            'latitude_kepulangan' => $validatedData['set_lat_input'],
            'longitude_kepulangan' => $validatedData['set_lang_input'],
            'file_kepulangan' => $fullpath
    ]);

    
        
        // return redirect()->route('home');
        return response()->json('success', 200);
    }

    public function profile($id, Guru $guru){
        $users = User::all()->where('id', $id);
        $idguru = Guru::get('id')->where('user_id', $id);
        
        return view('users.profile', compact('users', 'idguru'));
    }

    public function izin(Request $request, Siswa $siswa)
        {

            $user_id = $request->user()->id;
            $siswa_id = Siswa::where('user_id', $user_id)->first()->id;

            $image = base64_decode($request->photoStore);
            $safeName = 'clock_in_' . collect(explode(' ', auth()->user()->name))->join('_'). '_' . Carbon::now()->toDateString() . '.png';
            $fullpath = 'izin/'.$safeName;
            Storage::disk('public')->put($fullpath, $image);
    

            Absen::create([
                'siswa_id' => $siswa_id,
                'date' => now()->format('Y-m-d'),
                'keterangan' => $request->keterangan,
                'catatan' => $request->catatan,
            ]);

            return redirect()->route('home')->with('success', 'Izin berhasil diajukan.');
        }
}



