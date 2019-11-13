@extends('layouts.app')

@section('content')

<div id="app1">
    <label for="data_cursa" class="mb-0">Data plecării:<span class="text-danger">*</span></label>
    <vue2-datepicker
        data-veche="{{ old('data_cursa') == '' ? '' : old('data_cursa') }}"
        nume-camp-db="data_cursa"
        tip="date"
        latime="150"
        not-before="{{ \Carbon\Carbon::today() }}"
        {{-- disabled-dates="{{ \Carbon\Carbon::tomorrow() }}" --}}
        {{-- style="box-shadow: 0px 0px 5px yellow;" --}}
    ></vue2-datepicker>
    <vuejs-datepicker>
    </vuejs-datepicker>
</div>

@endsection