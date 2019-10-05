<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume'); //<-- we use global request to get the param of URI        
        $users = User::when($search_nume, function ($query, $search_nume) {
                return $query->where('name', 'like', '%' . $search_nume . '%');
            })
            ->latest()
            ->Paginate(25);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $users = User::make($this->validateRequest());
        // $this->authorize('update', $proiecte);
        $users->save();

        return redirect('/users')->with('status', 'Utilizatorul "' . $users->nume . '" a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $users)
    {
        return view('users.edit', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $users)
    {
        // $this->authorize('update', $proiecte);
        $users->update($this->validateRequest());

        return redirect('/users')->with('status', 'Utilizatorul "' . $users->name . '" a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $users)
    {
        // $this->authorize('delete', $produse);
        // dd($produse);
        $users->delete();
        return redirect('/users')->with('status', 'Utilizatorul "' . $users->name . '" a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        // dd ($request->_method);
        return request()->validate(
            [
                'name' => ['max:150'],
                'email' => ['max:150'],
                'password' => ['max:150'],
            ]
        );
    }
}
