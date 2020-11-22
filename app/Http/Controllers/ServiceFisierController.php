<?php

namespace App\Http\Controllers;

use App\ServiceFisier;
use App\ServiceFisa;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Storage;

class ServiceFisierController extends Controller
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
    public function store(Request $request, ServiceFisa $fisa)
    {
        $request->validate([
            // 'fisier' => 'required|mimes:pdf,xlx,csv,doc,docx,xml,jpg,jpeg|max:2048',
            'fisier' => [
                'required',
                'max:10000',
            ], 
        ]);

        $fisier = request()->file('fisier');
        $fileName = pathinfo($fisier->getClientOriginalName(), PATHINFO_FILENAME) .
            '.' .
            // \Carbon\Carbon::now()->isoFormat('HHMMSSDDMMYY') . '.' . 
            $fisier->extension();

        foreach($fisa->fisiere as $fisier_verifica){
            // echo $fisier->nume;
            // dd('stop');
            if ($fisier_verifica->nume === $fileName){
                return back()->with('error', 'Această fișă are deja un fișier cu numele de „' . $fileName . '”!');
            }
        }
        // $filePath = "contracte/" . date("Y") . '/' . date("m");
        $filePath = "fise/nr-intrare-" . $fisa->nr_intrare . '/';
        // dd($fisier, $fileName, $filePath);
        $fisier->storeAs($filePath, $fileName);
        // $request->fisier->move(public_path($filePath), $fileName);

        // Storage::disk('local')->put($filePath, $fileName);

        $fisier_database = new ServiceFisier;
        $fisier_database->service_fisa_id = $fisa->id;
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
    public function show(ServiceFisier $fisier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fisier  $fisier
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceFisier $fisier)
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
    public function update(Request $request, ServiceFisier $fisier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fisier  $fisier
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceFisier $fisiere)
    {
        $fisiere->delete();

        $cale_si_fisier = $fisiere->path . $fisiere->nume;
        Storage::delete($cale_si_fisier);

        //stergere director daca acesta este gol
        if (empty(Storage::allFiles($fisiere->path))) {
            Storage::deleteDirectory($fisiere->path);
        }

        // return redirect('/contracte')->with('status', 'Fișierul "' . $fisiere->nume . '" a fost șters cu succes!');
        return back()->with('status', 'Fișierul "' . $fisiere->nume . '" a fost șters cu succes!');
    }

    /**
     * Download files.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileDownload(Request $request, ServiceFisier $fisier)
    {
        // dd($fisier);
        $cale_si_fisier = $fisier->path . $fisier->nume;

        // $headers = array(
        //     'Content-Type: application/pdf',
        // );

        return Storage::download($cale_si_fisier);
    }
}
