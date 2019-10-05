@extends ('layouts.app')

@section('content')   
    <div class="container card">
        <div class="row card-header">
            <div class="col-lg-4 my-1">
                <h4 class="mt-2 mb-0"><a href="{{ route('users.index') }}"><i class="fas fa-users mr-1"></i>Utilizatori</a></h4>
            </div> 
            <div class="col-lg-4 my-1">
                <form class="needs-validation" novalidate method="GET" action="/users">
                    @csrf                    
                    <div class="input-group custom-search-form justify-content-center">
                        <div class="">
                            <input type="text" class="form-control" id="search_nume" name="search_nume" placeholder="Nume" autofocus>
                            {{-- <small class="form-text text-muted">Caută după cod de bare</small> --}}
                        </div>
                        <div class="">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search text-white"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            {{-- <div class="col-lg-4 text-right my-1">
                <a class="btn btn-primary" href="/produse/adauga" role="button">Adaugă Produs</a>
            </div> --}}
        </div>

        <div class="card-body">

            @if (session()->has('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped"> 
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>Nr. Crt.</th>
                            <th>Nume</th>
                            <th>Tip cont</th>
                            <th>Email</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>               
                        @forelse ($users as $user) 
                            <tr>                    
                                <td align="center">
                                    {{ ($users ->currentpage()-1) * $users ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    <b>{{ $user->name }}</b>
                                </td>
                                <td>
                                    {{ $user->provider }}
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    {{ $user->created_at }}
                                </td>
                            </tr>                                          
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination justify-content-center">
                        {{$users->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection