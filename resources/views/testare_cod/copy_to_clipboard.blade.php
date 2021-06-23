@extends ('layouts.app')

@section('content')
    <div id="copy_to_clipboard" v-cloak>
    <p>
    <label for="appId">App ID: </label>
    <input id="appId" v-model="appId">
    <button v-if="canCopy" @click="copy(appId)">Copy</button>
    </p>

    <p>
    <label for="appToken">App Token: </label>
    <input id="appToken" v-model="appToken">
    <button v-if="canCopy" @click="copy(appToken)">Copy</button>
    </p>
    </div>
@endsection
