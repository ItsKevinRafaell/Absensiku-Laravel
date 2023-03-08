<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Kelas = Kelas::latest()->paginate(5);
    
        return view('Kelas.index',compact('Kelas'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Kelas.create');
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
            'Kelas' => 'required',
        ]);
    
        Kelas::create($request->all());

        return redirect()->route('Kelas.index')
                        ->with('success','Berhasil Menyimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $Kelas
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $Kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $Kelas
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas $Kelas)
    {
        return view('Kelas.edit',compact('Kelas'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $Kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelas $Kelas)
    {
        $request->validate([
            'Kelas' => 'required',
        ]);
            
        $Kelas->update($request->all());
    
        return redirect()->route('Kelas.index')
                        ->with('success','Berhasil Update !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $Kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelas $Kelas)
    {
        $Kelas->delete();

        return redirect()->route('Kelas.index')
                        ->with('success','Berhasil Hapus !');
    }
}