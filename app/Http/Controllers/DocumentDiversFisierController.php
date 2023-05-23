<?php

namespace App\Http\Controllers;

use App\DocumentDiversFisier;
use App\DocumentUniversal;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class DocumentDiversFisierController extends Controller
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
    public function store(Request $request, DocumentUniversal $documentUniversal)
    {
        $request->validate([
            'fisier' => 'required|mimes:pdf,xlx,csv,doc,docx,xml|max:2048',
        ]);

        $fisier = request()->file('fisier');
        $fileName = pathinfo($fisier->getClientOriginalName(), PATHINFO_FILENAME) .
            // ' ' . \Carbon\Carbon::now()->isoFormat('HHMMSSDDMMYY') .
            '.' .
            $fisier->extension();
        // $filePath = "documentUniversal/" . date("Y") . '/' . date("m");
        $filePath = "Documente universale/" . $documentUniversal->id . '/';
        // dd($fisier, $fileName, $filePath);
        $fisier->storeAs($filePath, $fileName);
        // $request->fisier->move(public_path($filePath), $fileName);

        // Storage::disk('local')->put($filePath, $fileName);

        $fisier_database = new DocumentDiversFisier;
        $fisier_database->document_divers_id = $documentUniversal->id;
        $fisier_database->path = $filePath;
        $fisier_database->nume = $fileName;
        $fisier_database->save();

        return back()->with('success', 'Fișierul "' . $fileName . '" a fost încărcat cu succes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DocumentDiversFisier  $fisier
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentDiversFisier $fisier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DocumentDiversFisier  $fisier
     * @return \Illuminate\Http\Response
     */
    public function edit(DocumentDiversFisier $fisier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DocumentDiversFisier  $fisier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DocumentDiversFisier $fisier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DocumentDiversFisier  $fisier
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentDiversFisier $fisier)
    {
        // dd($fisier);
        $fisier->delete();

        $cale_si_fisier = $fisier->path . $fisier->nume;
        Storage::delete($cale_si_fisier);

        //stergere director daca acesta este gol
        if (empty(Storage::allFiles($fisier->path))) {
            Storage::deleteDirectory($fisier->path);
        }

        // return redirect('/contracte')->with('status', 'Fișierul "' . $fisiere->nume . '" a fost șters cu succes!');
        return back()->with('status', 'Fișierul "' . $fisier->nume . '" a fost șters cu succes!');
    }

    /**
     * Download files.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileDownload(Request $request, DocumentDiversFisier $fisier)
    {
        // dd($fisier);
        $cale_si_fisier = $fisier->path . $fisier->nume;

        // $headers = array(
        //     'Content-Type: application/pdf',
        // );

        return Storage::download($cale_si_fisier);
    }
}
