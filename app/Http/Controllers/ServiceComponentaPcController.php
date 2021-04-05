<?php

namespace App\Http\Controllers;

use App\ServiceComponentaPc;
use App\ServiceComponentaPcCategorie;
use App\ServiceComponentaPcImagine;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Image;

class ServiceComponentaPcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        $search_categorie_id = \Request::get('search_categorie_id');

        $componente_pc = ServiceComponentaPc::with('categorie')
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->when($search_categorie_id, function ($query, $search_categorie_id) {
                return $query->where('categorie_id', $search_categorie_id);
            })
            ->latest()
            ->simplePaginate(25);

        $categorii = ServiceComponentaPcCategorie::orderBy('nume')->get();

        return view('service.componente_pc.index', compact('componente_pc', 'categorii', 'search_nume', 'search_categorie_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorii = ServiceComponentaPcCategorie::orderBy('nume')->get();

        return view('service.componente_pc.create', compact('categorii'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRequest();
        $componenta_pc = ServiceComponentaPc::create($request->except(['imagini']));

        foreach ((array)$request->file('imagini') as $image) {
            $nume = $image->getClientOriginalName();
            $cale = '/uploads/imagini/componente_pc/' . $componenta_pc->id . '/';
            // $image->move(public_path() . $cale, $nume);

            Storage::disk('public')->makeDirectory($cale);

            $imagine = Image::make($image->path());
            $imagine->resize(1000, 1000, function ($const) {
                $const->aspectRatio();
            });
            $imagine->save(public_path($cale . $nume));

            $imagine = new ServiceComponentaPcImagine;
            $imagine->referinta_id = $componenta_pc->id;
            $imagine->referinta_categorie = 'componenta_pc';
            $imagine->imagine_nume = $nume;
            $imagine->imagine_cale = $cale;
            $imagine->save();
        }

        return redirect('/service/componente-pc')->with('status',
            'Componenta "' . $componenta_pc->nume . '" a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServiceComponentaPc  $componenta_pc
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceComponentaPc $componenta_pc)
    {
        return view('service.componente_pc.show', compact('componenta_pc'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceComponentaPc  $componenta_pc
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ServiceComponentaPc $componenta_pc)
    {
        $categorii = ServiceComponentaPcCategorie::orderBy('nume')->get();

        return view('service.componente_pc.edit', compact('componenta_pc', 'categorii'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceComponentaPc  $componenta_pc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceComponentaPc $componenta_pc)
    {
        $this->validateRequest();
        $componenta_pc->update($request->except(['imagini']));

        foreach ((array)$request->file('imagini') as $image) {
            $nume = $image->getClientOriginalName();
            $cale = '/uploads/imagini/componente_pc/' . $componenta_pc->id . '/';
            // $image->move(public_path() . $cale, $nume);

            Storage::disk('public')->makeDirectory($cale);

            $imagine = Image::make($image->path());
            $imagine->resize(1000, 1000, function ($const) {
                $const->aspectRatio();
            });
            $imagine->save(public_path($cale . $nume));

            $imagine = new ServiceComponentaPcImagine;
            $imagine->referinta_id = $componenta_pc->id;
            $imagine->referinta_categorie = 'componenta_pc';
            $imagine->imagine_nume = $nume;
            $imagine->imagine_cale = $cale;
            $imagine->save();
        }

        return redirect('/service/componente-pc')->with('status',
            'Componenta "' . $componenta_pc->nume . '" a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceComponentaPc  $componenta_pc
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceComponentaPc $componenta_pc)
    {
        $componenta_pc->delete();

        foreach ($componenta_pc->imagini as $imagine) {
            $cale_si_fisier = $imagine->imagine_cale . $imagine->imagine_nume;
            Storage::disk('public')->delete($cale_si_fisier);

            $imagine->delete();

            //stergere director daca acesta este gol
            if (empty(Storage::disk('public')->allFiles($componenta_pc->imagine->imagine_cale))) {
                Storage::disk('public')->deleteDirectory($componenta_pc->imagine->imagine_cale);
            }
        }

        return redirect('/service/componente-pc')->with('status',
            'Componenta "' . $componenta_pc->nume . '" a fost ștearsă cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceComponentaPc  $componenta_pc
     * @return \Illuminate\Http\Response
     */
    public function stergeImagine(ServiceComponentaPc $componenta_pc, ServiceComponentaPcImagine $imagine)
    {
        // dd($imagine->image_path);
        Storage::disk('public')->delete($imagine->imagine_cale . $imagine->imagine_nume);
        $imagine->delete();
        // $exists = Storage::disk('public')->exists('/' . $imagine->image_path);
        // $exists = Storage::disk('public')->exists('uploads/imagini/porumbei/5/Domestic-pigeon.jpg');


        //stergere director daca acesta este gol
        if (empty(Storage::disk('public')->allFiles($imagine->imagine_cale))) {
            Storage::disk('public')->deleteDirectory($imagine->imagine_cale);
        }

        return back();
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request = null)
    {
        return request()->validate([
            'nume' => 'required|max:250',
            'categorie_id' => 'required',
            'cantitate' => 'nullable|numeric|digits_between:1,4',
            'descriere' => 'nullable|max:1000',
            'observatii' => 'nullable|max:1000',
            'imagini.*' => 'nullable|mimes:jpg,jpeg,png,gif|max:10000'
        ]);
    }

    public function schimbaCantitatea(Request $request, ServiceComponentaPc $componenta_pc)
    {
        switch ($request->input('action')) {
            case 'minus':
                $componenta_pc->cantitate--;
                $componenta_pc->update();
                return back()->with('status', 'Cantitatea componentei „' . $componenta_pc->nume . '” a fost scazută cu 1 bucată');
                break;
            case 'plus':
                $componenta_pc->cantitate++;
                $componenta_pc->update();
                return back()->with('status', 'Cantitatea componentei „' . $componenta_pc->nume . '” a fost crescută cu 1 bucată');
                break;
            }
        return back();
    }
}
