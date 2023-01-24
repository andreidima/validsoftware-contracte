@csrf

<div class="form-row mb-0 d-flex border-radius: 0px 0px 40px 40px" id="app1">
    <div class="form-group col-lg-12 px-2 mb-0">
        <div class="form-row px-2 py-2 mb-2">
            <div class="form-group col-lg-6 mb-0">
                <label for="nume" class="mb-0 pl-1">Nume:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume') == '' ? $cron_job->nume : old('nume') }}"
                    required>
            </div>
            <div class="form-group col-lg-6 mb-0">
                <label for="client_id" class="mb-0 pl-3">Client:</label>
                <select name="client_id"
                    class="custom-select-sm custom-select rounded-pill {{ $errors->has('client_id') ? 'is-invalid' : '' }}"
                >
                        <option value='' selected>Selectează</option>
                    @foreach ($clienti as $client)
                        <option
                            value='{{ $client->id }}'
                                @if(old('client_id') !== null)
                                    @if ($client->id == old('client_id'))
                                        selected
                                    @endif
                                @else
                                    @if ($client->id == $cron_job->client_id)
                                        selected
                                    @endif
                                @endif
                        >{{ $client->nume }} </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-0 justify-content-center">
            <div class="form-group col-lg-11 mb-0 d-flex align-items-center">
                Emailul se va trimite lunar, in ziua de
                <select name="ziua"
                    class="custom-select-sm custom-select rounded-pill col-lg-2 ml-2 {{ $errors->has('ziua') ? 'is-invalid' : '' }}"
                >
                    @for ($i=1; $i < 29; $i++)
                        <option
                            value='{{ $i }}'
                                @if(old('ziua') !== null)
                                    @if ($i == old('ziua'))
                                        selected
                                    @endif
                                @else
                                    @if ($i == $cron_job->ziua)
                                        selected
                                    @endif
                                @endif
                        >{{ $i }} </option>
                    @endfor
                </select>
                , la ora
                {{-- <select name="ora"
                    class="custom-select-sm custom-select rounded-pill col-lg-2 mx-2 {{ $errors->has('ora') ? 'is-invalid' : '' }}"
                >
                    @for ($i=1; $i < 25; $i++)
                        <option
                            value='{{ $i }}'
                                @if(old('ora') !== null)
                                    @if ($i == old('ora'))
                                        selected
                                    @endif
                                @else
                                    @if ($i == $cron_job->ora)
                                        selected
                                    @endif
                                @endif
                        >{{ $i }} </option>
                    @endfor
                </select>   --}}
                <vue-datepicker-next
                    data-veche="{{ old('ora', $cron_job->ora) }}"
                    tip="time"
                    nume-camp-db="ora"
                    value-type="HH:mm"
                    format="HH:mm"
                    :latime="{ width: '80px' }"
                ></vue-datepicker-next>
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-0">
            <div class="form-group col-lg-12 mb-0">
                <label for="subiect" class="mb-0 pl-1">Subiect email:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('subiect') ? 'is-invalid' : '' }}"
                    name="subiect"
                    placeholder=""
                    value="{{ old('subiect') == '' ? $cron_job->subiect : old('subiect') }}"
                    required>
            </div>
        </div>
        <div class="form-row px-2 py-2 mb-0">
            <div class="form-group col-lg-12 mb-0">
                <label for="email" class="mb-0 pl-1">Email:</label>
                <tinymce-vue
                inputvalue="{{ old('email', $cron_job->email ?? '') }}"
                height= 300
                inputname="email"
                ></tinymce-vue>
            </div>
        </div>


        <div class="form-row mb-3 px-2 justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-sm mr-2 rounded-pill">{{ $buttonText }}</button>
                {{-- <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="{{ $clienti->path() }}">Renunță</a>  --}}
                <a class="btn btn-secondary btn-sm mr-4 rounded-pill" href="/cron-jobs">Renunță</a>
            </div>
        </div>
    </div>
</div>
