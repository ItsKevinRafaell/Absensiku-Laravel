<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Imports\UserImport;
use App\Models\SiswaKelas;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function import(Request $request)
    {
        $file = $request->file('file');
        $nama_file = rand().$file->getClientOriginalName();
        $file->move('DataUser',$nama_file);
        Excel::import(new UserImport, public_path('/DataUser/'.$nama_file));

        return redirect()->back()->with('success', 'Data User Berhasil Diimport!');
    }

   
}
