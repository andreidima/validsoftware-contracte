<?php

namespace App\Http\Controllers;

use App\Fisier;
use App\Contract;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class FisierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, Contract $contracte)
    {
        $request->validate([
            'fisier' => 'required|mimes:pdf,xlx,csv,doc,docx|max:2048',
        ]);

        $fisier = request()->file('fisier');
        $fileName = pathinfo($fisier->getClientOriginalName(), PATHINFO_FILENAME) . ' ' .
            \Carbon\Carbon::now()->isoFormat('HHMMSSDDMMYY') . '.' . 
            $fisier->extension();
        // $filePath = "contracte/" . date("Y") . '/' . date("m");
        $filePath = "contracte/" . $contracte->contract_nr . '/';
        // dd($fisier, $fileName, $filePath);
        $fisier->storeAs($filePath, $fileName);
        // $request->fisier->move(public_path($filePath), $fileName);

        // Storage::disk('local')->put($filePath, $fileName);

        $fisier_database = new Fisier;
        $fisier_database->contract_id = $contracte->id;
        $fisier_database->path = $filePath;
        $fisier_database->nume = $fileName;
        $fisier_database->save();

        return back()->with('success', 'Fișierul "' . $fileName . '" a fost încărcat cu succes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fisier  $fisier
     * @return \Illuminate\Http\Response
     */
    public function show(Fisier $fisier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fisier  $fisier
     * @return \Illuminate\Http\Response
     */
    public function edit(Fisier $fisier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fisier  $fisier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fisier $fisier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fisier  $fisier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fisier $fisiere)
    {
        // dd($fisiere);
        $fisiere->delete();

        $cale_si_fisier = $fisiere->path . $fisiere->nume;
        Storage::delete($cale_si_fisier);

        // return redirect('/contracte')->with('status', 'Fișierul "' . $fisiere->nume . '" a fost șters cu succes!');
        return back()->with('status', 'Fișierul "' . $fisiere->nume . '" a fost șters cu succes!');
    }

    /**
     * Download files.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileDownload(Request $request, Fisier $fisier)
    {
        // dd($fisier);
        $cale_si_fisier = $fisier->path . $fisier->nume;

        // $headers = array(
        //     'Content-Type: application/pdf',
        // );

        return Storage::download($cale_si_fisier);
    }
}
