@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-12">
                <h4 class=" mb-0"><a href="{{ route('service_servicii_reordonare_index') }}"><i class="fas fa-tools mr-1"></i>Service - servicii - reordonare</a></h4>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-sm rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="small" style="padding:2rem">
                            <th>Nr. de ordine</th>
                            <th>Serviciu service</th>
                            <th class="text-center">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($servicii as $serviciu)
                            <tr>
                                <td align="">
                                    {{ $serviciu->nr_de_ordine }}
                                </td>
                                <td align="">
                                    {{ $serviciu->nume }}
                                </td>
                                <td class="d-flex justify-content-end">
                                </td>
                            </tr>

                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination pagination-sm justify-content-center">
                        {{$servicii->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>
@endsection
